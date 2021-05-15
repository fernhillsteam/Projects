/*
 * architecture.c
 *
 *  Created on: 07-May-2021
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

#include "inc/spi_flash.h"
#include "inc/address_mapping.h"

uint32_t mem_address;
uint32_t ui32pageadd;
uint32_t sectoradd;


void address_mapping()
{
    page_index(0,0,1);
}


//*****************************************************************
// Calculate the address of page, sector and block
// using the size of each parameters.
// block_size is 65536
// sector_size is 4096 and
// page_size is 256
//
//*******************************************************************


uint32_t page_index(uint32_t blk_num, uint32_t sec_num, uint32_t page_num)
{
//    uint32_t mem_address;
    mem_address = (block_size * blk_num)+(sector_size * sec_num)+(page_size * page_num);
    UARTprintf("\nmem_address of block %d sector %d page %d is: %d\n",blk_num,sec_num,page_num,mem_address);
    return mem_address;
}








