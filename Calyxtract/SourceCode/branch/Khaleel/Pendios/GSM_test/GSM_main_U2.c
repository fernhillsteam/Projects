/*
 * Title: SIM800l PENDIOS IOT VOLTMETER PROJECT
 * author: khaleel
 * Description: The aim in the project to read the ac(voltage and current) and dc(voltage and current) values and upload the data to server
 * database. The system can also intimates about the error occured at that instant and also accepts trigger commands to perform actions
 * like : ondemand-sms and ondemand- dataupload.
 * */
#include <stdint.h>
#include <stdbool.h>
#include "stdio.h"
#include "stdlib.h"
#include "string.h"
#include <math.h>
#include "inc/hw_ints.h"
#include "inc/hw_memmap.h"
#include "driverlib/debug.h"
#include "driverlib/gpio.h"
#include "driverlib/interrupt.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"


#include "inc/global.h"
#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/GSM.h"
#include "inc/heartbeat.h"
#include "inc/delay.h"
#include "inc/lcd.h"

void gettime();

unsigned char test_count = 0;



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

/*GSM interface with Tiva tm4c1294ncpdt launchpad with sim800L*/
uint8_t SC_status=0, OV_status=0;
unsigned char* buff2;


int
main(void)
{

    //
    // Set the clocking to run directly from the crystal at 120MHz.
    //
   SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |SYSCTL_OSC_MAIN |SYSCTL_USE_PLL  |SYSCTL_CFG_VCO_480), 120000000);
   rs232_init(3);
   dbg_printf("Debug printf working on UART0\n");
   //Lcd_Init();
   GSM_init();
   GPRS_init();
//   server_update();
   //heartbeat_LED_init();
//   SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOC);
//   SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);SysCtlDelay(8000000);
//   GPIOPinTypeGPIOInput(GPIO_PORTC_BASE, GPIO_PIN_4|GPIO_PIN_5);
//   GPIOPadConfigSet(GPIO_PORTB_BASE, GPIO_PIN_2, GPIO_STRENGTH_2MA,GPIO_PIN_TYPE_STD_WPU);
//   GPIOPadConfigSet(GPIO_PORTB_BASE, GPIO_PIN_3, GPIO_STRENGTH_2MA,GPIO_PIN_TYPE_STD_WPU);

   //GSM_gen_APN();

  //gettime();

   //convert(240);
   //GSM_gen_url();

   //convert(uint32_tac_p);
 //  readresponse("AT+HTTPREAD\n"); //OK
//      SysCtlDelay(8000000);
 //     dbg_printf("\r\nresponse = %s",response);
   dbg_printf("\r\nUPDATED\n");


    while(1)
    {
//        dbg_printf("\r\nLoop\t");
//        SysCtlDelay(8000000);
//        SC_status = GPIOPinRead(GPIO_PORTC_BASE, GPIO_PIN_4);
//        OV_status = GPIOPinRead(GPIO_PORTC_BASE, GPIO_PIN_5);
//
//        if (SC_status == 0)
//        {
//            dbg_printf("Short circuit detected");
//            SysCtlDelay(8000000);
//            //server_update(3);
//            SC_update();
//        }
//        else if (OV_status == 0)
//        {
//            dbg_printf("Overload detected");
//            SysCtlDelay(8000000);
//            //server_update(2);
//            OV_update();
//        }

//        while(MAP_UARTCharsAvail(UART0_BASE))
//                   {
//                   MAP_UARTCharPutNonBlocking(UART2_BASE,
//                                                     MAP_UARTCharGetNonBlocking(UART0_BASE));
//                   }
//          while(MAP_UARTCharsAvail(UART2_BASE))
//                     {
//                     MAP_UARTCharPutNonBlocking(UART0_BASE,
//                                                        MAP_UARTCharGetNonBlocking(UART2_BASE));
//                     }

    }

}


void gettime()
{
uint8_t year,month,date,hour,minute;
unsigned char syear[4];//,smonth[2],sdate[2],shour[2],sminute[2];
//unsigned char time[]="";
year =21;
month = 3;
date=25;
hour=17;
minute=23;

dbg_printf("\nyear is %d, month is %d, date is %d, hour is %d, minute is %d",year, month, date, hour, minute);

dbg_printf("string is %s",syear);

//strcpy(time,"{\"CDATE\":");
//strcat(time,char(year));

}


