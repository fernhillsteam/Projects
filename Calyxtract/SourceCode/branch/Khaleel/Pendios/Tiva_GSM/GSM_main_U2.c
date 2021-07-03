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
#include "inc/tiny-json.h"

#define json 1

void gettime();

//uint8_t p=0;
//bool resp;
//char *url="XOX";
char str1[] = "{\"device\": \"fht001\", \"mobile\": \"08892782335\", \"auth\": \"0110\", \"server\": \"http://google.com\", \"apn\": \"bsnl\", \"user\": \"\", \"pass\": \"\", \"location\": \"india\", \"address\": \"bangalore\"}]";
 //  char str1[] = "{\"dir\": \"fwd\", \"frq\": \"5000\", \"encoder\": \"On\"}";
volatile uint8_t frame_rcvd=1;

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
    dbg_printf("\r\nCODE UPDATED\n");

   uint32_tac_v=240;
   uint32_tac_c=5;
   uint32_tdc_v=30;
   uint32_tdc_c=3 ;

    while(1)
    {
// Code here
//#if json == 1
//       if(frame_rcvd == 1)
//                {


        //           dbg_printf(direction);
        //           dbg_printf(frequency);
        //           dbg_printf(encoder);
//            dbg_printf("frame_rcvd is : %s\n",str1);
//            frame_rcvd=0;
//           json_t const* root = json_create( str1, pool, MAX_QTY );
//           char const* direction = json_getPropertyValue( root, "dir" );
//           char const* frequency = json_getPropertyValue( root, "frq" );
//           char const* encoder = json_getPropertyValue( root, "encoder" );
//          // strcpy(buff,direction);
//          dbg_printf("direction is : %s",direction );
//           dbg_printf("frequency is : %s",frequency);
//           dbg_printf("encoder is : %s",encoder);

//
//               }
//#endif
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


