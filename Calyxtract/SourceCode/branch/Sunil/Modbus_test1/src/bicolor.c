/*
 * bicolor.c
 *
 *  Created on: Sep 29, 2020
 *      Author: Khaleel
 */

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

#include "inc/bicolor.h"

void bicolor_init(void)
{
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOC); //Port C
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOE); //Port E
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOH);
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOD);
    GPIOPinTypeGPIOOutput(GPIO_PORTC_BASE, GPIO_PIN_4|GPIO_PIN_5|GPIO_PIN_6|GPIO_PIN_7);  //Pin 4,5,6,7
    GPIOPinTypeGPIOOutput(GPIO_PORTE_BASE, GPIO_PIN_0|GPIO_PIN_1|GPIO_PIN_2|GPIO_PIN_3);  //Pin 0,1,2,3
    GPIOPinTypeGPIOOutput(GPIO_PORTH_BASE, GPIO_PIN_2);  //Pin 0,1,2,3
    GPIOPinTypeGPIOOutput(GPIO_PORTD_BASE, GPIO_PIN_0|GPIO_PIN_1|GPIO_PIN_2|GPIO_PIN_3);  //Pin 0,1,2,3
}


