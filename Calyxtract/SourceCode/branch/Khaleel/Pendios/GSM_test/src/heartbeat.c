/*
 * heartbeat.c
 *
 *  Created on: Oct 5, 2020
 *      Author: Khaleel
 */
#include "inc/global.h"
#include "inc/heartbeat.h"
#include "inc/dbg.h"


void EVAL_BRD_LED1_init()
{
    // Enable the GPIO port that is used for the on-board LEDs.
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPION);

    // Enable the GPIO pins for the LEDs (PN0) D2.
    GPIOPinTypeGPIOOutput(GPIO_PORTN_BASE, GPIO_PIN_0 );
}

void heartbeat_LED_init()
{
#if EVAL_BRD_LED
    EVAL_BRD_LED1_init();
#endif
    //

    // Enable the peripherals used by this example.
    SysCtlPeripheralEnable(SYSCTL_PERIPH_TIMER0);
    //ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_TIMER1);



    //
    // Configure the two 32-bit periodic timers.
    //
    TimerConfigure(TIMER0_BASE, TIMER_CFG_PERIODIC);
    //ROM_TimerConfigure(TIMER1_BASE, TIMER_CFG_PERIODIC);
    TimerLoadSet(TIMER0_BASE, TIMER_A, g_ui32SysClock/3);
    //ROM_TimerLoadSet(TIMER1_BASE, TIMER_A, g_ui32SysClock / 2);


    // Enable processor interrupts.
     IntMasterEnable();
    //
    // Setup the interrupts for the timer timeouts.
    //
    IntEnable(INT_TIMER0A);
    //ROM_IntEnable(INT_TIMER1A);
    TimerIntEnable(TIMER0_BASE, TIMER_TIMA_TIMEOUT);
    //ROM_TimerIntEnable(TIMER1_BASE, TIMER_TIMA_TIMEOUT);

    // Enable the timers.
    TimerEnable(TIMER0_BASE, TIMER_A);
    //ROM_TimerEnable(TIMER1_BASE, TIMER_A);

            GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_0, GPIO_PIN_0);
            // Delay for 1 millisecond.  Each SysCtlDelay is about 3 clocks.
            SysCtlDelay(8000000);
            // Turn off the LED
            GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_0, 0);
}

void Timer0IntHandler(void)
{
// Clear the timer interrupt
//TimerIntClear(TIMER0_BASE, TIMER_TIMA_TIMEOUT);
    TimerIntClear(TIMER0_BASE, TIMER_TIMA_TIMEOUT);
    // Read the current state of the GPIO pin and
// write back the opposite state
if(GPIOPinRead(GPIO_PORTN_BASE, GPIO_PIN_0))
{
GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_0, 0);
}
else
{
GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_0, GPIO_PIN_0);
}
dbg_printf("\ninterrupt UPDATED\n");
}
