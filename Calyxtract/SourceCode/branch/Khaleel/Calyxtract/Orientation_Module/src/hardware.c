/*
 * hardware.c
 *
 *  Created on: Jul 1, 2021
 *      Author: yallo
 */
#define TARGET_IS_TM4C129_RA1
#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_ints.h"
#include "inc/hw_types.h"
#include "inc/hw_memmap.h"
#include "inc/hw_udma.h"
#include "inc/hw_ssi.h"
#include "driverlib/debug.h"
#include "driverlib/gpio.h"
#include "driverlib/interrupt.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/udma.h"
#include "driverlib/ssi.h"
#include "driverlib/uart.h"

#include "inc/hardware.h"
#include "inc/RS_232.h"
#include "inc/sccb.h"
#include "inc/ov7725.h"


//#Variables//
#pragma DATA_ALIGN(dma_table, 1024)
static uint8_t dma_table[1024];

void hw_clk_config()
{   //
    // Set the clocking to run directly from the crystal at 120MHz.
    //
    SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |SYSCTL_OSC_MAIN |SYSCTL_USE_PLL  |SYSCTL_CFG_VCO_480), 120000000);
}

void hw_gpio_inout()
{

    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPION);//PORT N as input
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOH);//PORT H as output

    GPIOPinTypeGPIOOutput(GPIO_PORTN_BASE, GPIO_PIN_0|GPIO_PIN_1|GPIO_PIN_2|GPIO_PIN_3|GPIO_PIN_4|GPIO_PIN_5);  //PORT N Pin 0,1,2,3,4,5
    GPIOPinTypeGPIOOutput(GPIO_PORTH_BASE, GPIO_PIN_0|GPIO_PIN_1|GPIO_PIN_2|GPIO_PIN_3);  //PORT H Pin 0,1,2,3
}

void hw_DMA_init(void)
{
    ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_UDMA);

    MAP_uDMAEnable();
    MAP_uDMAControlBaseSet(&dma_table[0]);
    MAP_uDMAChannelAssign(UDMA_CH12_GPIOK);
    uDMAChannelAttributeDisable(UDMA_CH12_GPIOK, UDMA_ATTR_ALL);

    MAP_uDMAChannelControlSet(UDMA_CH12_GPIOK|UDMA_PRI_SELECT,
                                UDMA_SIZE_8|
                                UDMA_SRC_INC_NONE|
                                UDMA_DST_INC_8|
                                UDMA_ARB_1);
#if 0
    MAP_uDMAChannelTransferSet(UDMA_SEC_CHANNEL_UART2RX_12|UDMA_ALT_SELECT,
                            UDMA_MODE_BASIC,
                            &HWREG(GPIO_PORTM_BASE + (0x00U + (0xFFU << 2))),
                            img_buffer,
                            1);

    ROM_uDMAChannelEnable(UDMA_SEC_CHANNEL_UART2RX_12);
#endif

    MAP_uDMAChannelAssign(UDMA_CH6_TIMER2A);
    uDMAChannelAttributeDisable(UDMA_CH6_TIMER2A, UDMA_ATTR_ALL);

    MAP_uDMAChannelControlSet(UDMA_CH6_TIMER2A|UDMA_PRI_SELECT,
                                UDMA_SIZE_16|
                                UDMA_SRC_INC_16|
                                UDMA_DST_INC_NONE|
                                UDMA_ARB_1);
}

void hw_I2C_init()
{
    SCCB0_Init(); //sccb.c
}

void hw_init()
{
    //Clk init
    hw_clk_config(); //hardware.c

    //GPIO init
    #ifdef gpio_init
    hw_gpio_inout(); //hardware.c
    #endif

    //initialising UART-RS232
    #ifdef uart_init
        rs232_init(both);  // initializing uart0 and uart2- RS232.c
    #endif

    //SPI init
    #ifdef spi_init

    #endif

    //I2C init
    #ifdef i2c_init
        hw_I2C_init();//hardware.c
    #endif

    //DMA init
    #ifdef dma_init
        hw_DMA_init(); //hardware.c
    #endif

    //Camera init
    #ifdef camera_init
        cam_ov7725_init();
    #endif

    //CAN module init
    #ifdef can_init

    #endif

    //Flash memory init
    #ifdef flash_init

    #endif

}// EOF hw_init

void hw_dma_set_img(uint8_t *p_img)
{
    MAP_uDMAChannelTransferSet(UDMA_CH12_GPIOK|UDMA_PRI_SELECT, UDMA_MODE_BASIC,
                               &HWREG(GPIO_PORTM_BASE + (0x00U + (0xFFU << 2))),
                               p_img,
                               320*2);

    ROM_uDMAChannelAttributeEnable(UDMA_CH12_GPIOK, UDMA_ATTR_HIGH_PRIORITY);

    ROM_uDMAChannelEnable(UDMA_CH12_GPIOK);
}

uint8_t hw_is_dma_img_complete(void)
{
    return (MAP_uDMAChannelModeGet(UDMA_CH12_GPIOK) == UDMA_MODE_STOP);
}
