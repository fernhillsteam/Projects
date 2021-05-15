/*
 * spi_flash.h
 *
 *  Created on: 06-May-2021
 *      Author: Sunil Pawar
 */

#ifndef INC_SPI_FLASH_H_
#define INC_SPI_FLASH_H_

#define CMD_WRSR                0x01        // Write status register
#define CMD_PP                  0x02        // Page program
#define CMD_READ                0x03        // Read data
#define CMD_WRDI                0x04        // Disable writes
#define CMD_RDSR                0x05        // Read status register
#define CMD_WREN                0x06        // Enable writes
#define CMD_FREAD               0x0b        // Fast read data
#define CMD_SE                  0x20        // Sector erase (4K)
#define CMD_DREAD               0x3b        // 1 in 2 out read data
#define CMD_BE32                0x52        // Block erase (32K)
#define CMD_QREAD               0x6b        // 1 in 4 out read data
#define CMD_RDID                0x9f        // Read JEDEC ID
#define CMD_CE                  0xc7        // Chip erase
#define CMD_BE64                0xd8        // Block erase (64K)


void SSI0_init();
void UART_Init();
void hardware_init();
void device_information();

void chip_select_high(void);
void chip_select_low(void);
void SPI_Write_Enable(); // WEL
void SPI_Write_Disable();


void SPIFlashReadID(uint8_t *pui8ManufacturerID, uint16_t *pui16DeviceID);
void SPIFlashPageProgram(uint32_t ui32Addr, uint8_t *pui8DataTx, uint32_t ui32Count);
void SPIFlashRead(uint32_t ui32Addr, uint8_t *pui8DataRx, uint32_t ui32Count);
void SPIFlashSectorErase1(uint32_t ui32Addr);
void SPIFlashBlockErase64(uint32_t ui32Addr);
void SPIFlashWriteStatus();
void SPIFlashSectorErase(uint32_t blk_num, uint32_t sec_num);
uint8_t ReadStatus();

uint8_t SPIFlashCharPageProgram(uint32_t ui32Addr, uint8_t *pui8DataTx, uint32_t ui32Count);
void SPIFlashCharRead(uint32_t ui32Addr, uint8_t *confRx, uint32_t ui32Count);
void CopyArray(uint8_t *source, uint8_t *dest, uint8_t count);
extern uint32_t ui32pageadd;
extern uint32_t mem_address;
extern uint8_t TransmitBuffer[255];

#endif /* INC_SPI_FLASH_H_ */
