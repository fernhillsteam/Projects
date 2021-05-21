/*
 * spi_flash.c
 *
 *  Created on: 06-May-2021
 *      Author: Sunil Pawar
 */

#include <stdbool.h>
#include <stdint.h>
#include "inc/hw_ssi.h"
#include "inc/hw_types.h"
#include "driverlib/udma.h"
#include "inc/hw_udma.h"
#include "inc/hw_memmap.h"
#include "driverlib/gpio.h"
#include "driverlib/pin_map.h"
#include "driverlib/ssi.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"

#include "inc/spi_flash.h"
#include "inc/address_mapping.h"

uint8_t pui8ManufacturerID;
uint16_t pui16DeviceID;
uint32_t g_ui32SysClock;
uint8_t TransmitBuffer[255] = {0};

void hardware_init()
{
    g_ui32SysClock = SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ | SYSCTL_OSC_MAIN | SYSCTL_USE_PLL | SYSCTL_CFG_VCO_480), 120000000);//120mhz
    SSI0_init();
    UART_Init();
}

void device_information()
{
    SPIFlashReadID(&pui8ManufacturerID, &pui16DeviceID);

    UARTprintf("\nManufacture_id is: %X \n",pui8ManufacturerID);
    UARTprintf("Device_id is: %x\n",pui16DeviceID);
}

void SSI0_init(void)
{
    uint32_t ui32Trash;

    SysCtlPeripheralEnable(SYSCTL_PERIPH_SSI0);
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOA);
    GPIOPinTypeGPIOInput(GPIO_PORTA_BASE, GPIO_PIN_3);

//  GPIOPinConfigure(GPIO_PA3_SSI0FSS);

    GPIOPinConfigure(GPIO_PA2_SSI0CLK);
    GPIOPinConfigure(GPIO_PA4_SSI0XDAT0);  // SSI0Rx MOSI
    GPIOPinConfigure(GPIO_PA5_SSI0XDAT1);  // SSI0Tx MISO

    GPIOPinTypeSSI(GPIO_PORTA_BASE,GPIO_PIN_5|GPIO_PIN_4|GPIO_PIN_2);

    SSIConfigSetExpClk(SSI0_BASE, 16000000, SSI_FRF_MOTO_MODE_0, SSI_MODE_MASTER, 1000000, 8);

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);

    SSIAdvModeSet(SSI0_BASE,SSI_ADV_MODE_WRITE); //new

    // Enable the frame hold feature.

    SSIAdvFrameHoldEnable(SSI0_BASE);

    SSIEnable(SSI0_BASE);

    while(SSIDataGetNonBlocking(SSI0_BASE, &ui32Trash)){}
}

void UART_Init()
{
    SysCtlPeripheralEnable(SYSCTL_PERIPH_UART0);
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOA);

    GPIOPinConfigure(GPIO_PA0_U0RX);
    GPIOPinConfigure(GPIO_PA1_U0TX);
    GPIOPinTypeUART(GPIO_PORTA_BASE, GPIO_PIN_0| GPIO_PIN_1);

    UARTClockSourceSet(UART0_BASE, UART_CLOCK_PIOSC);
    UARTStdioConfig(0, 115200, 16000000);

    SysCtlDelay(8000000);
}


void chip_select_high(void)   //Chip Select Enable, PA3
{
    GPIOPinTypeGPIOOutput(GPIO_PORTA_BASE, GPIO_PIN_3);
    GPIOPinWrite(GPIO_PORTA_BASE, GPIO_PIN_3, GPIO_PIN_3);
}

void chip_select_low(void) //Chip Select Disable, PA3
{
    GPIOPinTypeGPIOOutput(GPIO_PORTA_BASE, GPIO_PIN_3);
    GPIOPinWrite(GPIO_PORTA_BASE, GPIO_PIN_3, 0);
}

void SPI_Write_Enable()
{
    chip_select_low();                        //  enable device
    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);
    SSIDataPut(SSI0_BASE,CMD_WREN);        //  send W25X_Write_Enable command 0x06
//    SSIAdvDataPutFrameEnd(SSI0_BASE, 0x06);
    chip_select_high();                          //  disable device

}

void SPI_Write_Disable()
{
    chip_select_low();                            //  enable device
    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);
    SSIDataPut(SSI0_BASE,CMD_WRDI);                  //  send W25X_Write_disable command 0x04
//    SSIAdvDataPutFrameEnd(SSI0_BASE, 0x04);
    chip_select_high();
}

void SPIFlashSectorErase1(uint32_t ui32Addr)
{

    SPI_Write_Enable();
    chip_select_low();
    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    SSIDataPut(SSI0_BASE, CMD_SE); // sector erase command is 0x20

    // Send the address of the sector to be erased, marking the last byte of
    // the address as the end of the frame.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIAdvDataPutFrameEnd(SSI0_BASE, ui32Addr & 0xff);
    UARTprintf("\nsector erase Address is: %u\n",ui32Addr);

    chip_select_high();
    UARTprintf("Sector Erase complete:\n  ");
}


void SPIFlashSectorErase(uint32_t blk_num, uint32_t sec_num)
{
    uint32_t ui32Addr = (block_size * blk_num)+(sector_size * sec_num);

    SPI_Write_Enable();
    chip_select_low();
    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    SSIDataPut(SSI0_BASE, CMD_SE); // sector erase command is 0x20

    // Send the address of the sector to be erased, marking the last byte of
    // the address as the end of the frame.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIAdvDataPutFrameEnd(SSI0_BASE, ui32Addr & 0xff);
    UARTprintf("\nsector erase Address is: %u\n",ui32Addr);

    chip_select_high();
    UARTprintf("Sector Erase complete:\n  ");
}


//*****************************************************************************
//
//! Erases a 64 KB block of the SPI flash.
//!
//! \param ui32Base is the SSI module base address.
//! \param ui32Addr is the SPI flash address to erase.
//!
//! This function erases a 64 KB block of the SPI flash.  Each 64 KB block has
//! a 64 KB alignment; the SPI flash will ignore the lower 16 bits of the
//! address provided.  The 64 KB block erase command is issued by this
//! function; SPIFlashReadStatus() must be used to query the SPI flash to
//! determine when the 64 KB block erase operation has completed.  This uses
//! the 0xd8 SPI flash command.
//!
//! \return None.
//
//*****************************************************************************

void SPIFlashBlockErase64(uint32_t ui32Addr)
{
    SPI_Write_Enable();
    chip_select_low();

    // Set the SSI module into write-only mode.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    // Send the 64 KB block erase command command.

    SSIDataPut(SSI0_BASE, CMD_BE64);    // Block erase (64K) command is 0xd8

    // Send the address of the 64 KB block to be erased, marking the last byte
    // of the address as the end of the frame.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIAdvDataPutFrameEnd(SSI0_BASE, ui32Addr & 0xff);

    chip_select_high();
    UARTprintf("Block Erase complete:\n  ");
}

//*****************************************************************************
//
//! Erases the entire SPI flash.
//!
//! \param ui32Base is the SSI module base address.
//!
//! This command erase the entire SPI flash.  The chip erase command is issued
//! by this function; SPIFlashReadStatus() must be used to query the SPI flash
//! to determine when the chip erase operation has completed.  This uses the
//! 0xc7 SPI flash command.
//!
//! \return None.
//
//*****************************************************************************

void w25q80_spi_ChipErase()
{
    SPI_Write_Enable();
    chip_select_low();

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    SSIAdvDataPutFrameEnd(SSI0_BASE, CMD_CE);  // send the Chip erase command 0xc7

    chip_select_high();
    SPI_Write_Disable();
    SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
    SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
    UARTprintf("chip Erase complete:\n  ");
}


void SPIFlashReadID(uint8_t *pui8ManufacturerID, uint16_t *pui16DeviceID)
{
    uint32_t ui32Data1, ui32Data2;

    chip_select_low();

    while(SSIDataGetNonBlocking(SSI0_BASE, &ui32Data1) != 0)
    {
    }

    // Set the SSI module into write-only mode.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    // Send the read ID command.

    SSIDataPut(SSI0_BASE, CMD_RDID);    // CMD_RDID = 0x9f    (Read JEDEC ID)

    // Set the SSI module into read/write mode.  In this mode, dummy writes are
    // required in order to make the transfer occur; the SPI flash will ignore the data.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);

    // Send three dummy bytes, marking the last as the end of the frame.

    SSIDataPut(SSI0_BASE, 0x00);
    SSIDataPut(SSI0_BASE, 0x00);
    SSIAdvDataPutFrameEnd(SSI0_BASE, 0x00);

    // Read the first returned data byte, which contains the manufacturer ID.

    SSIDataGet(SSI0_BASE, &ui32Data1);
    *pui8ManufacturerID = ui32Data1 & 0xff;

//   UARTprintf(pui8ManufacturerID[i]);
//   Read the remaining two data bytes, which contain the device ID.

    SSIDataGet(SSI0_BASE, &ui32Data1);
    SSIDataGet(SSI0_BASE, &ui32Data2);
    *pui16DeviceID = ((ui32Data1 & 0xff) << 8) | (ui32Data2 & 0xff);

    chip_select_high();
}

//*****************************************************************************
//
//! Programs the SPI flash.
//!
//! \param ui32Base is the SSI module base address.
//! \param ui32Addr is the SPI flash address to be programmed.
//! \param pui8Data is a pointer to the data to be programmed.
//! \param ui32Count is the number of bytes to be programmed.
//!
//! This function programs data into the SPI flash, using PIO mode.  This
//! function will not return until the entire program command has been written
//! into the SSI transmit FIFO.  This uses the 0x02 SPI flash command.
//!
//! \return None.
//*****************************************************************************

void SPIFlashPageProgram(uint32_t ui32Addr, uint8_t *pui8DataTx, uint32_t ui32Count)
{
    SPI_Write_Enable();
    chip_select_low();
    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    // Send the page program command.

    SSIDataPut(SSI0_BASE, CMD_PP);  // Page Program command = 0x02

    // Send the address of the first byte to program.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIDataPut(SSI0_BASE, ui32Addr & 0xff);
    UARTprintf("\nTx Address is: %x\n",ui32Addr);

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);

    while(ui32Count > 0)
    {
        SSIDataPut(SSI0_BASE, *pui8DataTx);
        UARTprintf("Tx Data is: %d\n",*pui8DataTx);
        *pui8DataTx++;
        ui32Count--;
    }

    chip_select_high();
    UARTprintf("write process complete:\n  ");

}


//*****************************************************************************
//
//! Reads data from the SPI flash.
//!
//! \param ui32Base is the SSI module base address.
//! \param ui32Addr is the SPI flash address to read.
//! \param pui8Data is a pointer to the data buffer to into which to read the
//! data.
//! \param ui32Count is the number of bytes to read.
//!
//! This function reads data from the SPI flash, using PIO mode.  This function
//! will not return until the read has completed.  This uses the 0x03 SPI flash
//! command.
//!
//! \return None.
//*****************************************************************************

void  SPIFlashRead(uint32_t ui32Addr, uint8_t *pui8DataRx, uint32_t ui32Count)
{
    uint32_t ui32Trash;
    chip_select_low();
    // Drain any residual data from the receive FIFO.
    while(SSIDataGetNonBlocking(SSI0_BASE, &ui32Trash) != 0)
    {
    }

    // Set the SSI module into write-only mode.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    // Send the read command.

    SSIDataPut(SSI0_BASE, CMD_READ);   // READ command = 0x03

    // Send the address of the first byte to read.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIDataPut(SSI0_BASE, ui32Addr & 0xff);

    UARTprintf("\nRx Address is: %x\n",ui32Addr);

    // Set the SSI module into read/write mode.  In this mode, dummy writes are
    // required in order to make the transfer occur; the SPI flash will ignore the data.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);

//    while(ui32Count > 0)
//    {
//        // Send the next data byte.
//
//        SSIDataPut(SSI0_BASE, 0x00);
//
//        SSIDataGet(SSI0_BASE, &ui32Addr);
//        UARTprintf("Rx Data is: %d\n",ui32Addr);
//        *pui8DataRx++ = ui32Addr & 0xff;
//        ui32Count--;
//    }

    while(ui32Count > 0)
    {
        SSIDataPut(SSI0_BASE, 0x00);
        SSIDataGet(SSI0_BASE,(uint32_t*) &pui8DataRx);
        UARTprintf("Rx Data is: %d\n",pui8DataRx);
        pui8DataRx++;
        ui32Count--;
    }

    chip_select_high();
    SysCtlDelay(16666);
    UARTprintf("Read process complete:\n  ");
}

uint8_t SPIFlashCharPageProgram(uint32_t ui32Addr, uint8_t *pui8DataTx, uint32_t ui32Count)
{

    SPI_Write_Enable();
    chip_select_low();

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    CopyArray(pui8DataTx, TransmitBuffer, ui32Count);
    // Send the page program command.

    SSIDataPut(SSI0_BASE, CMD_PP);  // Page Program command = 0x02

    // Send the address of the first byte to program.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIDataPut(SSI0_BASE, ui32Addr & 0xff);
    UARTprintf("\nTx Address is: %x\n\n",ui32Addr);

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);

    while(ui32Count > 0)
    {
        SSIDataPut(SSI0_BASE, *pui8DataTx);
        UARTprintf("Tx Data is: %c\n",*pui8DataTx);
        *pui8DataTx++;
        ui32Count--;
    }

    chip_select_high();
    UARTprintf("write process complete:\n  ");
    return 0;
}

void SPIFlashCharRead(uint32_t ui32Addr, uint8_t *confRx, uint32_t ui32Count)
{
    uint32_t ui32Trash;
    chip_select_low();
    // Drain any residual data from the receive FIFO.
    while(SSIDataGetNonBlocking(SSI0_BASE, &ui32Trash) != 0)
    {
    }

    // Set the SSI module into write-only mode.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_WRITE);

    // Send the read command.

    SSIDataPut(SSI0_BASE, CMD_READ);   // READ command = 0x03

    // Send the address of the first byte to read.

    SSIDataPut(SSI0_BASE, (ui32Addr >> 16) & 0x0000ff);
    SSIDataPut(SSI0_BASE, (ui32Addr >> 8) & 0x00ff);
    SSIDataPut(SSI0_BASE, ui32Addr & 0xff);

    UARTprintf("Rx Address is: %x\n\n",ui32Addr);

    // Set the SSI module into read/write mode.  In this mode, dummy writes are
    // required in order to make the transfer occur; the SPI flash will ignore the data.

    SSIAdvModeSet(SSI0_BASE, SSI_ADV_MODE_READ_WRITE);


    while(ui32Count > 0)
    {
        SSIDataPut(SSI0_BASE, 0x00);
        SSIDataGet(SSI0_BASE,(uint32_t*) &confRx);
        UARTprintf("Rx Data is: %c\n",confRx);
        confRx++;
        ui32Count--;
    }

    chip_select_high();
    SysCtlDelay(16666);
    UARTprintf("Read process complete:\n  ");

}

void CopyArray(uint8_t *source, uint8_t *dest, uint8_t count)
{
    uint8_t copyIndex = 0;
    for (copyIndex = 0; copyIndex < count; copyIndex++)
    {
        dest[copyIndex] = source[copyIndex];
        //UARTprintf("copied Data is: %c\n",dest[copyIndex]);
    }
}
