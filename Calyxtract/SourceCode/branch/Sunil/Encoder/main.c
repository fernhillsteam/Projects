#include <stdbool.h>
#include <stdint.h>
#include "inc/hw_ssi.h"
#include "inc/hw_types.h"
#include "driverlib/qei.h"
//#include "inc/hw_udma.h"
#include "inc/hw_memmap.h"
#include "driverlib/gpio.h"
#include "driverlib/pin_map.h"
#include "driverlib/ssi.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"
//
//uint32_t qeiPosition = 0;

volatile uint32_t qeiPosition;
volatile uint32_t qeiDirection;
volatile uint32_t qeiVelocity;

void Init_QEI0()
{
       // printf("Initializing QEI ...");
    // Enable QEI Peripherals

    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOL);
    SysCtlPeripheralEnable(SYSCTL_PERIPH_QEI0);

    //Set Pins to be PHA0 and PHB0

    GPIOPinConfigure(GPIO_PL1_PHA0);
    GPIOPinConfigure(GPIO_PL2_PHB0);
    GPIOPinConfigure(GPIO_PL3_IDX0);

    //Set GPIO pins for QEI. PhA0 -> PD6, PhB0 ->PD7. I believe this sets the pull up and makes them inputs

    GPIOPinTypeQEI(GPIO_PORTL_BASE, GPIO_PIN_1 |  GPIO_PIN_2);
    GPIOPinTypeQEI(GPIO_PORTL_BASE, GPIO_PIN_3); // idx0

        //DISable peripheral and int before configuration

    QEIDisable(QEI0_BASE);
    QEIIntDisable(QEI0_BASE,QEI_INTERROR | QEI_INTDIR | QEI_INTTIMER | QEI_INTINDEX);

// Configure quadrature encoder, use an arbitrary top limit of 1000 (65536)

    QEIConfigure(QEI0_BASE, QEI_CONFIG_CAPTURE_A_B | QEI_CONFIG_NO_RESET | QEI_CONFIG_QUADRATURE | QEI_CONFIG_NO_SWAP, 1000);

        // enable QEI module
    QEIEnable(QEI0_BASE);

//  QEIIntEnable(QEI0_BASE, (QEI_INTERROR | QEI_INTINDEX | QEI_INTDIR));

        //Set Register start Values
//    QEIPositionSet(QEI0_BASE,500);  // 65536/2=32768
    QEIPositionSet(QEI0_BASE,00);  // 65536/2=32768


    // configure a velocity measurement
    QEIVelocityConfigure(QEI0_BASE, QEI_VELDIV_1, (SysCtlClockGet()/10)); // measure speed during last 100ms

    // enable velocity measurement
    QEIVelocityEnable(QEI0_BASE);


    QEIFilterConfigure (QEI0_BASE,
                        QEI_FILTCNT_17);
    QEIFilterEnable (QEI0_BASE);
//    QEIFilterConfigure (QEI1_BASE,
//                        QEI_FILTCNT_17);
//    QEIFilterEnable (QEI1_BASE);

    //Add qeiPosition as a watch expression to see the value inc/dec


}

void UART_Init()
{
    SysCtlPeripheralEnable(SYSCTL_PERIPH_UART0);
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOA);

    GPIOPinConfigure(GPIO_PA0_U0RX);
    GPIOPinConfigure(GPIO_PA1_U0TX);
    GPIOPinTypeUART(GPIO_PORTA_BASE, GPIO_PIN_0| GPIO_PIN_1);

    UARTClockSourceSet(UART0_BASE, UART_CLOCK_PIOSC);
    UARTStdioConfig(0, 115200, 16000000);

    UARTprintf("\nuart_init\n  ");
    SysCtlDelay(8000000);

}


int main(void)
{
 //   uint8_t ManufacturerID;
 //   uint16_t DeviceID;
    MAP_SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |
                                             SYSCTL_OSC_MAIN |
                                             SYSCTL_USE_PLL |
                                             SYSCTL_CFG_VCO_480), 120000000);

  //  UARTprintf("\nspi_init\n  ");
//    uint32_t ui32Base=SSI0_BASE;

    UART_Init();
    UARTprintf("\nmain_init\n  ");
    Init_QEI0();
//
//    UARTprintf("\nEncoder_init\n  ");
    while (1) //This is the main loop of the program
    {
        qeiPosition =  QEIPositionGet(QEI0_BASE);
//        qeiDirection = QEIDirectionGet(QEI0_BASE);
//        qeiVelocity =  QEIVelocityGet(QEI0_BASE);
   //     SysCtlDelay (8000000/2);
        UARTprintf("\nencoder = %d\t  ",qeiPosition );
//        UARTprintf("\tdirection = %d\t  ",qeiDirection );
//        UARTprintf("\tvelocity = %d\n  ",qeiVelocity );
    }


}



