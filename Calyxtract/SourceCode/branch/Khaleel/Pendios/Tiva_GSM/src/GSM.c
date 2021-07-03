/*
 * GSM.c
 *
 *  Created on: Mar 17, 2021
 *      Author: Admin
 */
#include <stdint.h>
#include <stdbool.h>
#include <stdio.h>
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
#include <string.h>

#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/GSM.h"
#include "inc/global.h"
#include "inc/atcommand.h"
//#include "inc/include.h"
#include "inc/tiny-json.h"

enum { MAX_QTY = 18 };
json_t pool[MAX_QTY];

void GSM_init()
{
    Gsm_Upready();
    Gsm_Attention();
    Gsm_EchoOff();
    Gsm_msg_format();
    Gsm_packet_detach();
    Gsm_packet_attach();
    SysCtlDelay(8000000);

}

void GPRS_init()
{
    Gsm_contype();
    Gsm_apn();
    Gsm_bearer_attach();
    SysCtlDelay(8000000);
}

//void connectGSM (char *cmd, char *res)
//{
// while(1)
// {
//   //Serial.println(cmd);
//   UARTprintf("%s",cmd);
//   dbg_printf("%s",cmd);
//   SysCtlDelay(8000000/2);
//   while(MAP_UARTCharsAvail(UART2_BASE))
//   {
//     if(GSMgetResponse(OK))
//     {
//         SysCtlDelay(8000000);
//       return;
//     }
//   }
//   SysCtlDelay(8000000);
//  }
//}
//
//int
//GSMgetResponse(char *expResponse)
//{
//    bool readResponse = true;       // Keeps the loop open while getting message
//    int readLine = 1;               // Counts the lines of the message
//    char *GSMresponse = NULL;       // Use to grab input
//    static char g_cInput[128];      // String input to a UART
//
//    while ( readResponse )
//    {
//        // Grab a line
//        UARTgets(g_cInput,sizeof(g_cInput));
//        dbg_printf("uartget");
//        // Stop after newline and store to global message array
//        GSMresponse = strtok(g_cInput,"\n");
//        strcpy(responseLine[readLine], GSMresponse);
//
//        // If this line has our expected response we've got the whole message
//        if ( strstr(responseLine[readLine],expResponse) != '\0' )
//        {readResponse = false;}
//        else
//        { readLine++; }
//    }
//
//        // Return the number of lines total in the message (for indexing)
//    return readLine;
//}

char response_check(char *buf)
{
  int i;char x = 0;
  for(i=0;buf[i]!='\0';i++)
  {
    do
    {
      if(MAP_UARTCharsAvail(UART2_BASE)>0)
        x=MAP_UARTCharGetNonBlocking(UART2_BASE);
    }while((x != buf[i]));
    //buf++;
  }
  return 1;
}

//void sendcmd (char *cmd)
//{   uint8_t char_count=0;
//
//   // UARTprintf("%s", cmd);
//    for(char_count=0;char_count<=strlen(cmd);char_count++)
//        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);
//    SysCtlDelay(8000000);
//
//    if(response_check("OK"))
//        {
//        dbg_printf("%s",cmd);
//        dbg_printf(" Success\n");
//        }
//}

unsigned char sendcmdg (char *cmd)
{

    UARTprintf("%s", cmd);
//    for(char_count=0;char_count<=strlen(cmd);char_count++)
//        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);

    //MAP_UARTCharPutNonBlocking(UART2_BASE,0x0D);
    SysCtlDelay(8000000/2);
    if(response_check("OK"))
        {
        dbg_printf("\r\n%s",cmd);
        dbg_printf(" Success\n");
        return 1;
        }
    else
        {
        dbg_printf("ERROR");
        return 0;
        }
}

void Gsm_fetch_conf()
{


         if(Gsm_http_init()) //http initialised
                   {
                   dbg_printf("\r\nHttp Initialized");
                   }
               else if (Gsm_http_term()) //if http is already open, terminate the connection
                   {
                   dbg_printf("Http Terminated");

                   if(Gsm_http_init())   //Re-initialise the http connection
                       {
                           dbg_printf("Http Re-Initialized");
                       }
                   }

               Gsm_http_contextid(); //OK
               SysCtlDelay(8000000);
               //GSM_gen_fault_URL();
               //dbg_printf("%s",fault);

               sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter-0.1/voltmeter/fetch_conf.php\"\n"); //OK
               //sendcmd(fault);
               SysCtlDelay(8000000);

               Gsm_http_action();

               //#define DebugPrint
               //dbg_printf("\r\nresponse = %s",response);
               //#endif

               SysCtlDelay(8000000);

               Gsm_http_read();
               dbg_printf("\r\nresponse = %s",response);

               Gsm_http_term(); //OK
               SysCtlDelay(8000000);
               parse_config(response);
               //response[200] = {0};
               memset(response, 0, sizeof(response));
       dbg_printf("\n\rConfiguration fetched\n");
}

void Gsm_fault_update()
{


         if(Gsm_http_init()) //http initialised
                   {
                   dbg_printf("\r\nHttp Initialized");
                   }
               else if (Gsm_http_term()) //if http is already open, terminate the connection
                   {
                   dbg_printf("Http Terminated");

                   if(Gsm_http_init())   //Re-initialise the http connection
                       {
                           dbg_printf("Http Re-Initialized");
                       }
                   }

               Gsm_http_contextid(); //OK
               SysCtlDelay(8000000);
               //GSM_gen_fault_URL();
               //dbg_printf("%s",fault);

               sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter-0.1/voltmeter/indicator_insert.php?sc=0001&st=0001&ov=0001&tp=0000&hl=0001\"\n"); //OK
               //sendcmd(fault);
               SysCtlDelay(8000000);

               Gsm_http_action();

               //#define DebugPrint
               //dbg_printf("\r\nresponse = %s",response);
               //#endif

               SysCtlDelay(8000000);

               Gsm_http_read();
               dbg_printf("\r\nresponse = %s",response);

               Gsm_http_term(); //OK
               SysCtlDelay(8000000);

               //response[200] = {0};
               memset(response, 0, sizeof(response));
       dbg_printf("\nFault updated\n");
}



void server_update()
{
    dbg_printf("\n\rSERVER UPDATE STARTED\n");

    if(Gsm_http_init()) //http initialised
              {
              dbg_printf("\r\nHttp Initialized");
              }
          else if (Gsm_http_term()) //if http is already open, terminate the connection
              {
              dbg_printf("Http Terminated");

              if(Gsm_http_init())   //Re-initialise the http connection
                  {
                      dbg_printf("Http Re-Initialized");
                  }
              }

          Gsm_http_contextid(); //OK
          SysCtlDelay(8000000);
          //GSM_gen_fault_URL();
          //dbg_printf("%s",fault);

          sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter/insert_db2.php?time=10-04-2021_18:42&ac_v=220&ac_c=10&ac_p=2300&dc_v=24&dc_c=10&dc_p=240\"\n"); //OK
          //sendcmd(fault);
          SysCtlDelay(8000000);

          Gsm_http_action();

          //#define DebugPrint
          //dbg_printf("\r\nresponse = %s",response);
          //#endif

          SysCtlDelay(8000000);

          Gsm_http_read();
          dbg_printf("\r\nresponse = %s",response);

          Gsm_http_term(); //OK
          SysCtlDelay(8000000);
          //response[200] = {0};
          memset(response, 0, sizeof(response));
          dbg_printf("\nSERVER UPDATED\n");
}

void gen_url()
{
char url[128] ="";
//unsigned char buff[100]="";

strcpy(url,Httpurl);
strcat(url,api);
//strcat(url,api_key);
strcat(url,"&time=");
strcat(url, time);
strcat(url,"&ac_v=");
//sprintf(buff,"%d",uint32_tac_v);
//dbg_printf("%s",buff);
//strcat(url,char(uint32_tac_v));
strcat(url,"&field3=");
//strcat(url,"&field4=");
//strcat(url,"&field5=");

//url = "AT+HTTPPARA=\"URL\",\"";
//url+= api;
//url+= api_key;
//url+= "&field1=";  //AC Voltage
//url+= char(uint32_tac_v);
//url+= "&field2=";  //AC Current
//url+= char(uint32_tac_c);
//url+= "&field3=";  //DC Voltage
//url+= char(uint32_tdc_v);
//url+= "&field4=";  //DC Current
//url+= char(uint32_tdc_c);
//url+= "&field5=";  //Time Stamp
//url+= get_time();
//url+= "\"\n"
        dbg_printf("%s",url);
       // itoa(240, buff, 10);
       // dbg_printf("\nitoa=%s",buff);
}

void parse_config(char config[200])
{
char *x_config;

x_config = strstr(config, "{");
//dbg_printf("\n\r#output# %s", x_config);

//                 dbg_printf("\n\rframe_rcvd is : %s\n",x_config);
                 //frame_rcvd=0;
                 json_t const* root = json_create( x_config, pool, MAX_QTY );
                 char const* device = json_getPropertyValue( root, "device" );
                 char const* mobile = json_getPropertyValue( root, "mobile" );
                 char const* auth = json_getPropertyValue( root, "auth" );
                 char const* server = json_getPropertyValue( root, "server" );
                 char const* apn = json_getPropertyValue( root, "apn" );
                 char const* user = json_getPropertyValue( root, "user" );
                 char const* pass = json_getPropertyValue( root, "pass" );
                 char const* location = json_getPropertyValue( root, "location" );
                 char const* address = json_getPropertyValue( root, "address" );

                 dbg_printf("\n\rdevice id  is : %s",device );
                 dbg_printf("\n\rmobile no is : %s",mobile);
                 dbg_printf("\n\rauth is : %s",auth);
                 dbg_printf("\n\rserver link  is : %s",server );
                 dbg_printf("\n\rApn is : %s",apn);
                 dbg_printf("\n\rusername is : %s",user);
                 dbg_printf("\n\rpassword  is : %s",pass );
                 dbg_printf("\n\rLocation is : %s",location);
                 dbg_printf("\n\rAddress is : %s",address);
}

void parse_button(char config[200])
{
char *x_config;

x_config = strstr(config, "{");
//dbg_printf("\n\r#output# %s", x_config);

//                 dbg_printf("\n\rframe_rcvd is : %s\n",x_config);
                 //frame_rcvd=0;
                 json_t const* root = json_create( x_config, pool, MAX_QTY );
                 char const* send_sms = json_getPropertyValue( root, "device" );
                 char const* send_data = json_getPropertyValue( root, "mobile" );
                 char const* auth_access = json_getPropertyValue( root, "auth" );
                 char const* shutdown = json_getPropertyValue( root, "server" );

                 dbg_printf("\n\rsend sms  is : %s",send_sms );
                 dbg_printf("\n\rsend_data  is : %s",send_data );
                 dbg_printf("\n\rauth_access is : %s",auth_access);
                 dbg_printf("\n\rshutdown  is : %s",shutdown );

}


char* itoa(int num, char* str, int base)
{
    int i = 0;
    bool isNegative = false;

    /* Handle 0 explicitely, otherwise empty string is printed for 0 */
    if (num == 0)
    {
        str[i++] = '0';
        str[i] = '\0';
        return str;
    }

    // In standard itoa(), negative numbers are handled only with
    // base 10. Otherwise numbers are considered unsigned.
    if (num < 0 && base == 10)
    {
        isNegative = true;
        num = -num;
    }

    // Process individual digits
    while (num != 0)
    {
        int rem = num % base;
        str[i++] = (rem > 9)? (rem-10) + 'a' : rem + '0';
        num = num/base;
    }

    // If number is negative, append '-'
    if (isNegative)
        str[i++] = '-';

    str[i] = '\0'; // Append string terminator

    // Reverse the string
   // reverse(str, i);

    return str;
}

void Gsm_readyf()
{

    dbg_printf("Checking GSMsms!!!\r\n");
    //dbg_printf("%s", Gsm_ready);
    //UARTprintf("%s", Gsm_ready);
    UARTprintf("AT+CMGS=\"7899996093\"\n");
   // SysCtlDelay(8000000/2);
   // UARTprintf("\n");


//    UARTprintf("test message from FHT");
//    UARTprintf("%d", 26);

    if(response_check(">"))
                              {
        //UARTprintf("AT+CMGS=\"7899996093\"");
        UARTprintf("test message from FHT");
        SysCtlDelay(8000000/2);
        UARTprintf("%c", 0x1A);
                              }

}

//void GSMread()
//{    char k;
//
//     //while(MAP_UARTCharsAvail(UART2_BASE));
//SysCtlDelay(8000000/2);
//     while(MAP_UARTCharsAvail(UART2_BASE))
//                   {
//
//                                                     k=MAP_UARTCharGetNonBlocking(UART2_BASE);
//                                                     if(k != "\n")
//                                                     dbg_printf("%c", k);
//                                                     //k++;
//
//                   }
//
//}
