/*
 * UART0 ANd UART2 testing code.
 * */
//#include "inc/include.h"

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
//#include "utils/uartstdio.c"

#include "inc/global.h"
#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/GSM.h"
//#include "inc/heartbeat.h"
#include "inc/delay.h"
#include "inc/lcd.h"
#include "inc/hardware.h"
#include "inc/atcommand.h"

void gettime();

uint8_t p=0;
bool resp;
char *url="XOX";



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



int
main(void)
{


    Configure_clk(); // Clock configuration
    hw_init();
    dbg_printf("\r\nGSM-GPRS TESTING V1.0\r\nAuthor- KHALEEL \n");
   //Lcd_Init();

//
//   server_update();
   //heartbeat_LED_init();
   dbg_printf("\r\ntimer UPDATED\n");//LCD_OutString("TIMER UPDTD");SysCtlDelay(8000000);LCD_Clear();


   uint32_tac_v=240;
   uint32_tac_c=5;
   uint32_tdc_v=30;
   uint32_tdc_c=3 ;
   //uint32_tmstmp[]= "{\"hello\"}";//"\{\"Current_date\" : \"2021-03-25\", \"current_time\" : \"17-30\"\}";   //{"Current_date" : "yyyy-mm-dd", "current_time : "hh-mm"}
   //gettime();
  // gen_url();
//Gsm_readyf();

   //LCD_OutChar('G');SysCtlDelay(64000); LCD_OutChar('O');SysCtlDelay(64000); //LCD_OutChar('O');SysCtlDelay(64000); LCD_OutChar('D');
    while(1)
    {

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


