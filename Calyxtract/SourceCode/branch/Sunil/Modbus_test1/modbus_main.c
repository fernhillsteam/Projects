#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_memmap.h"
#include "inc/hw_types.h"
#include "driverlib/gpio.h"
#include "drivers/pinout.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"

#include "Timer0_A.h"
#include "RS_232.h"
#include "bicolor.h"
#include "modbus.h"


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


//*****************************************************************************
//
// Print "Hello World!" to the UART on the Intelligent UART Module.
//
//*****************************************************************************

uint8_t test_writingRegisters(uint16_t u16ReadAddress, uint16_t u16ReadQty)
{
    _u16ReadAddress = u16ReadAddress;
    _u16ReadQty = u16ReadQty;
//    UARTprintf("MODBUS Write TESTING 2.0\n");
    return ModbusMasterTransaction(ku8MBWriteSingleRegisters);
}

int
main(void)
{
    //
    // Run from the PLL at 120 MHz.
    // Note: SYSCTL_CFG_VCO_240 is a new setting provided in TivaWare 2.2.x and
    // later to better reflect the actual VCO speed due to SYSCTL#22.
    //
    g_ui32SysClock = MAP_SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |
                                             SYSCTL_OSC_MAIN |
                                             SYSCTL_USE_PLL |
                                             SYSCTL_CFG_VCO_480), 120000000);

//    Timer_init(40);
//   rs232_init(3); //UART0 configured
    bicolor_init();
    UART0_init();

    GPIOPinWrite(GPIO_PORTH_BASE,GPIO_PIN_2,GPIO_PIN_2); // Contactor

    ModbusMaster_begin(); //modbus master init

//    TimersEnable(  );

    SysCtlDelay(8000000);
    SysCtlDelay(8000000);




    test_writingRegisters(8,4); // forward

    SysCtlDelay(8000000);
    SysCtlDelay(8000000);

    while(1)//;

    {
        GPIOPinWrite(GPIO_PORTD_BASE,GPIO_PIN_0,GPIO_PIN_0);
        SysCtlDelay(8000000);
        GPIOPinWrite(GPIO_PORTD_BASE,GPIO_PIN_0,0X00);
        SysCtlDelay(8000000);
    }


}



