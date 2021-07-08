/*
 * UART0 ANd UART2 testing code.
 * */


#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_ints.h"
#include "inc/hw_memmap.h"
#include "inc/hw_ssi.h"
#include "driverlib/debug.h"
#include "driverlib/gpio.h"
#include "driverlib/qei.h"
#include "driverlib/interrupt.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/ssi.h"
#include "driverlib/uart.h"
#include "utils/spi_flash.h"
#include "utils/spi_flash.c"
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"

#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/controller.h"

#define NUM_SSI_DATA            4

uint8_t ManufacturerID;
uint16_t DeviceID;
//****************************************************************************
//
// System clock rate in Hz.
//
//****************************************************************************
uint32_t g_ui32SysClock;

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
    hw_init();
    //Orientation process
    while(1)
    {
        controller();
    }

}
