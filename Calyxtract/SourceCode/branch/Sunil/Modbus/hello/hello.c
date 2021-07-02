//*****************************************************************************
//
// hello.c - Simple hello world example.
//
// Copyright (c) 2013-2020 Texas Instruments Incorporated.  All rights reserved.
// Software License Agreement
// 
// Texas Instruments (TI) is supplying this software for use solely and
// exclusively on TI's microcontroller products. The software is owned by
// TI and/or its suppliers, and is protected under applicable copyright
// laws. You may not combine this software with "viral" open-source
// software in order to form a larger program.
// 
// THIS SOFTWARE IS PROVIDED "AS IS" AND WITH ALL FAULTS.
// NO WARRANTIES, WHETHER EXPRESS, IMPLIED OR STATUTORY, INCLUDING, BUT
// NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
// A PARTICULAR PURPOSE APPLY TO THIS SOFTWARE. TI SHALL NOT, UNDER ANY
// CIRCUMSTANCES, BE LIABLE FOR SPECIAL, INCIDENTAL, OR CONSEQUENTIAL
// DAMAGES, FOR ANY REASON WHATSOEVER.
// 
// This is part of revision 2.2.0.295 of the EK-TM4C1294XL Firmware Package.
//
//*****************************************************************************

#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_memmap.h"
#include "inc/hw_types.h"
#include "driverlib/gpio.h"
//#include "drivers/pinout.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"
#include <string.h>

#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "tiny-json.h"
#include "inc/global_var.h"
#include "inc/modbus.h"
#include "inc/bicolor.h"

//*****************************************************************************
//
//! \addtogroup example_list
//! <h1>Hello World (hello)</h1>
//!
//! A very simple ``hello world'' example.  It simply displays ``Hello World!''
//! on the UART and is a starting point for more complicated applications.
//!
//! Open a terminal with 115,200 8-N-1 to see the output for this demo.
//
//*****************************************************************************

//*****************************************************************************
//
// System clock rate in Hz.
//
//*****************************************************************************
uint32_t g_ui32SysClock;


//unsigned char *str=0;
volatile unsigned char str[100],buff[12];
unsigned char i2=0,j2=0;
volatile uint8_t frame_rcvd=0;
//*****************************************************************************
//
// The error routine that is called if the driver library encounters an error.
//
//*****************************************************************************
#ifdef DEBUG
void
__error__(char *pcFilename, uint32_t ui32Line)
{
}
#endif


int
main(void)
{
    g_ui32SysClock = MAP_SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |
                                                SYSCTL_OSC_MAIN |
                                                SYSCTL_USE_PLL |
                                                SYSCTL_CFG_VCO_480), 120000000);

    rs232_init(3);
    ModbusMaster_begin();
    bicolor_init();

//    char str1[] = "{\"dir\": \"fwd\", \"frq\": \"5000\", \"encoder\": \"On\"}";

    enum { MAX_QTY = 6 };
    json_t pool[MAX_QTY];
//    json_t const* root = json_create( str, pool, MAX_QTY );
//
//    char const* datavalue = json_getPropertyValue( root, "dir" );
//
//    dbg_printf(datavalue);
    dbg_printf("welcome to modbus :");
 //   dbg_printf("%s",str1);
    while(1)
    {
        if(frame_rcvd == 1)
        {
            dbg_printf("frame_rcvd is : %s\n",str);
            frame_rcvd=0;
           json_t const* root = json_create( str, pool, MAX_QTY );
           char const* direction = json_getPropertyValue( root, "dir" );
           char const* frequency = json_getPropertyValue( root, "frq" );
           char const* encoder = json_getPropertyValue( root, "encoder" );
           strcpy(buff,direction);
          dbg_printf("direction is : %s",direction );
           dbg_printf("frequency is : %s",frequency);
           dbg_printf("encoder is : %s",encoder);

//           dbg_printf(direction);
//           dbg_printf(frequency);
//           dbg_printf(encoder);

        }

        if(strcmp(buff,"fwd")==0)
        {
            // forward

            dbg_printf("welcome fwd");
            GPIOPinWrite(GPIO_PORTC_BASE, GPIO_PIN_4,GPIO_PIN_4);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                test_writingRegisters(8,2);
                                GPIOPinWrite(GPIO_PORTC_BASE, GPIO_PIN_4,0);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                memset(buff,0,12);

        }
        else if(strcmp(buff,"rev")==0)
        {
            // reverse

            dbg_printf("welcome rev");
            GPIOPinWrite(GPIO_PORTC_BASE, GPIO_PIN_6,GPIO_PIN_6);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                test_writingRegisters(8,4);
                                GPIOPinWrite(GPIO_PORTC_BASE, GPIO_PIN_6,0);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                memset(buff,0,12);
        }
        else if(strcmp(buff,"stp")==0)
        {
            // stop

            dbg_printf("welcome stp");
            GPIOPinWrite(GPIO_PORTE_BASE, GPIO_PIN_0,GPIO_PIN_0);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                test_writingRegisters(8,0);
                                GPIOPinWrite(GPIO_PORTE_BASE, GPIO_PIN_0,0);
                                SysCtlDelay(8000000);
                                SysCtlDelay(8000000);
                                memset(buff,0,12);
        }

    }
}

void
UART0IntHandler(void)
{
    uint32_t ui32Status;

    //
    // Get the interrrupt status.
    //
    ui32Status = MAP_UARTIntStatus(UART0_BASE, true);

    //
    // Clear the asserted interrupts.
    //
    MAP_UARTIntClear(UART0_BASE, ui32Status);

    //
    // Loop while there are characters in the receive FIFO.
    //
    while(MAP_UARTCharsAvail(UART0_BASE))
    {
        //
        // Read the next character from the UART and write it back to the UART.
        //

    j2 = UARTCharGetNonBlocking(UART0_BASE);

   str[i2] =j2;
 //   i++;
//    dbg_printf("data rcvd is : %c \n", str[i]);
    i2++;
    if (j2=='}' )
    {
        frame_rcvd=1;
        i2=0;
        j2=0;

    }

    }
}
