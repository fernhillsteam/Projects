/*
 * configuration.c
 *
 *  Created on: 14-May-2021
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
#include "inc/configuration.h"

void device_configuration()
{
    SPIFlashSectorErase(0,0);
    SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
    *(TransmitBuffer+3) = '0';
    *(TransmitBuffer+4) = '1';
    *(TransmitBuffer+5) = '2';
    *(TransmitBuffer+6) = '3';

    SPIFlashCharPageProgram(mem_address, (uint8_t *)(TransmitBuffer), 7);

    SysCtlDelay(8000000);
    device_config_read();
}

void device_config_read()
{
    SPIFlashCharRead(mem_address, TransmitBuffer, 7);
}

void mobile_configuration()
{
    SPIFlashSectorErase(0,0);
    SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
    *(TransmitBuffer+7)  = '+';
    *(TransmitBuffer+8)  = '9';
    *(TransmitBuffer+9)  = '1';
    *(TransmitBuffer+10) = '9';
    *(TransmitBuffer+11) = '8';
    *(TransmitBuffer+12) = '4';
    *(TransmitBuffer+13) = '5';
    *(TransmitBuffer+14) = '0';
    *(TransmitBuffer+15) = '1';
    *(TransmitBuffer+16) = '2';
    *(TransmitBuffer+17) = '3';
    *(TransmitBuffer+18) = '4';
    *(TransmitBuffer+19) = '5';

    SPIFlashCharPageProgram(mem_address, (uint8_t *)(TransmitBuffer), 20);
    SysCtlDelay(8000000);

    mobile_config_read();
}

void mobile_config_read()
{
    SPIFlashCharRead(mem_address, TransmitBuffer, 20);
}

//******************************************************************************//

void configuration()
{
    unsigned char uc8cmd;

    UARTprintf("\nEnter your choice : \n");

    UARTprintf("\n a for add the parameters : \n");
    UARTprintf("\n d for delete the parameters : \n");
    UARTprintf("\n e for edit the parameters: \n");

    while(1)
    {
           while(UARTCharsAvail(UART0_BASE))
           {
               uc8cmd = UARTCharGetNonBlocking(UART0_BASE);
               UARTprintf("\nYour Choice is %c\n", uc8cmd);
               switch (uc8cmd)
               {
                case 'a':
                    UARTprintf("\nadd the parameters : \n");
                    //adding_parameters();
                    break;

                case 'd':
                    UARTprintf("\ndelete the parameters : \n");
                    //deleting_parameters();
                    break;

                case 'e':
                    UARTprintf("\nwhich parameter do you want to edit : \n");
                    //edit_parameters();
                    break;

               }
           }
    }

}


