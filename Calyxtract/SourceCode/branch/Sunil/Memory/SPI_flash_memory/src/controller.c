/*
 * controller.c
 *
 *  Created on: 07-May-2021
 *      Author: LENOVO
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
#include "inc/configuration.h"

unsigned char uc8cmd;
uint8_t pui8DataRx;
//uint8_t pui8buffer;
//uint8_t ui8readbuffer;
unsigned char conf_buffer[255]={'T','M','4','C','1','2','9','+','9','1','9','9','8','8','7','7','6','6','5','5'};
uint8_t confRx;
uint8_t history;

uint8_t mem_map_pagebuffer[255] = {100,101,102,103,104,105,106,107,108,109,110};
//extern uint32_t mem_address;
//extern uint32_t ui32pageadd;

uint8_t page_buf[255]={200,201,202,203,204,205,206,207,208,209,210};
uint32_t pagebase_addr=0x000000;
uint32_t pagebase_addr1=0x000100;

//uint8_t local_var[6];

void ControllerFunc()
{
//    UARTprintf("\nconfiguration file parameters : \n");
//
//    UARTprintf("DEVICE_ID : %s\n", DEVICE_ID);
//    UARTprintf("APN : %s\n", APN);
//    UARTprintf("MOBIL_NUM : %s\n", MOBIL_NUM);
//    UARTprintf("USER_NAME : %s\n", USER_NAME);
//    UARTprintf("PASSWORD : %s\n", PASSWORD);
//    UARTprintf("SERVER_LINK : %s\n", SERVER_LINK);
//    UARTprintf("AUTH_CODE : %s\n", AUTH_CODE);
//    UARTprintf("\nDou you want to change the \nconfiguration file parameters : \n");
//    UARTprintf("\n\"Y\"/\"y\" for yes\n \"N\"/\"n\" for no \n");

    UARTprintf("\nEnter your choice : \n");
    while(1)
    {
           while(UARTCharsAvail(UART0_BASE))
           {
               uc8cmd = UARTCharGetNonBlocking(UART0_BASE);
               UARTprintf("\nYour Choice is %c\n", uc8cmd);
               switch (uc8cmd)
               {
                    case 'e':   // sector_erase
                        SPIFlashSectorErase(0,0);   // block 0 and sector 0
                       break;

                    case 'w':   // write
                        SPIFlashPageProgram(mem_address, mem_map_pagebuffer, 11);
                       break;

                    case 'r':   // read
                        SPIFlashRead(mem_address, &pui8DataRx, 11);
                       break;

//                    case 'a':   //write
//                        SPIFlashPageProgram(mem_address, mem_map_pagebuffer, 11);
//                       break;

                    case 'z':   // write
                        SPIFlashPageProgram(pagebase_addr, page_buf, 11);
                       break;

                    case 'h':   // full sector read
                        SPIFlashRead(pagebase_addr, &pui8DataRx, mem_address+11);   //3851
                       break;




                    case 'x':   //write
                        SPIFlashSectorErase(0,0);
                        SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
                        SPIFlashCharPageProgram(mem_address, conf_buffer, 20);
                       break;

                    case 'y':   // read
                        SPIFlashCharRead(mem_address, &confRx, 20);
                       break;

                    case 'c':   // read the copied data
                        SPIFlashCharRead(mem_address, TransmitBuffer, 20);
                        //configuration();
                       break;

                    case 'i':   //rewrite the data
                        SPIFlashSectorErase(0,0);
                        SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
                        *(TransmitBuffer+4) = '0';*(TransmitBuffer+5) = '0';*(TransmitBuffer+6) = 'x';
                        SPIFlashCharPageProgram(mem_address, (uint8_t *)(TransmitBuffer), 20);
                       break;

                    case 'v':   //read the updated data
                        SPIFlashCharRead(mem_address, TransmitBuffer, 20);
                       break;


                    default:
                        UARTprintf("\n Enter valid choice !");
                        break;
               }
           }
    }
}


