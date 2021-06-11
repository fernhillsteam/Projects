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

void GSM_init()
{
    /*
//            UARTprintf("AT+CPIN?\n");//ok
//            if(response_check("+CPIN"))
//                   {
//                   //dbg_printf("%s",cmd);
//                   dbg_printf("GSM Ready\n");
//                   }
        sendcmd("AT+CFUN=1\n"); //OK
        SysCtlDelay(8000000);

    sendcmd("AT\r"); //OK           //ping the modem
    SysCtlDelay(8000000);
    sendcmd("ATE0\n"); //OK         //echo off
    SysCtlDelay(8000000);
    sendcmd("AT+CGATT=0\n"); //OK   //GPRS Detach
    SysCtlDelay(8000000);
    sendcmd("AT+CGATT=1\n"); //OK   //GPRS Attach
    SysCtlDelay(8000000);
*/
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
    //    UARTprintf("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"\n");
    //    if(response_check("OK"))
    //               {
    //               //dbg_printf("%s",cmd);
    //               dbg_printf(" Success\n");
    //               }
//        sendcmdg("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"\n");//OK
//        SysCtlDelay(8000000);
//        sendcmdg("AT+SAPBR=3,1,\"APN\",\"bsnlnet\"\n");//OK
//        SysCtlDelay(8000000);
//        sendcmdg("AT+SAPBR=1,1\n");//OK
//        SysCtlDelay(8000000);
//        sendcmdg("AT+SAPBR=2,1\n");//OK
//        SysCtlDelay(8000000);
    Gsm_contype();
    Gsm_apn();
    Gsm_bearer_attach();


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

void sendcmd (char *cmd)
{   uint8_t char_count=0;

   // UARTprintf("%s", cmd);
    for(char_count=0;char_count<=strlen(cmd);char_count++)
        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);
    SysCtlDelay(8000000);

    if(response_check("OK"))
        {
        dbg_printf("%s",cmd);
        dbg_printf(" Success\n");
        }
}

unsigned char sendcmdg (char *cmd)
{

    UARTprintf("%s", cmd);
//    for(char_count=0;char_count<=strlen(cmd);char_count++)
//        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);

    //MAP_UARTCharPutNonBlocking(UART2_BASE,0x0D);
    SysCtlDelay(8000000/2);
    if(response_check("OK"))
        {
        dbg_printf("%s",cmd);
        dbg_printf(" Success\n");
        return 1;
        }
    else
        {
        dbg_printf("ERROR");
        return 0;
        }
}




void server_update()
{ unsigned char status;
    dbg_printf("\nSERVER entered\n");

//    sendcmdg("AT+HTTPTERM\n"); //OK
//    SysCtlDelay(8000000);
    status = sendcmdg("AT+HTTPINIT\n"); //OK
    dbg_printf("%c",status);
    if(status == '0')
    {
            sendcmdg("AT+HTTPTERM\n"); //OK
            SysCtlDelay(8000000);
            sendcmdg("AT+HTTPINIT\n"); //OK
            SysCtlDelay(8000000);
    }
    SysCtlDelay(8000000);
    sendcmdg("AT+HTTPPARA=\"CID\",1\n"); //OK
    SysCtlDelay(8000000);
    //sendcmdg("AT+HTTPPARA=\"URL\",\"api.thingspeak.com/update?api_key=SCZTUL09JSNVP3F0&field1=240&filed2=3&field3=31&field4=45&field5=8.30\"\n"); //OK
    sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter/insert_db2.php?time=10-04-2021_18:42&ac_v=220&ac_c=10&ac_p=2300&dc_v=24&dc_c=10&dc_p=240\"\n"); //OK
    SysCtlDelay(8000000);
    sendcmdg("AT+HTTPACTION=0\n"); //OK
    SysCtlDelay(8000000);

//    sendcmdg("AT+HTTPREAD\n"); //OK
//    SysCtlDelay(8000000);

    sendcmdg("AT+HTTPTERM\n"); //OK
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);
    SysCtlDelay(8000000);

    //dbg_printf("\nGPRS Server updated\n");
    dbg_printf("\nSERVER UPDATED\n");
}

void gen_url()
{
unsigned char url[128] ="";
unsigned char buff[100]="";

strcpy(url,"AT+HTTPPARA=\"URL\",\"");
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
char k;


    dbg_printf("Checking GSMsms!!!\r\n");
    //dbg_printf("%s", Gsm_ready);
    //UARTprintf("%s", Gsm_ready);
    UARTprintf("AT+CMGS=\"7899996093\"");
    UARTprintf("%c", 0x0A);
    SysCtlDelay(8000000/2);

//    UARTprintf("test message from FHT");
//    UARTprintf("%d", 26);

    if(response_check(">"))
                              {
        //UARTprintf("AT+CMGS=\"7899996093\"");
        UARTprintf("test message from FHT");
        UARTprintf("%c", 0x1A);
                              }

}

void GSMread()
{    char k;

     //while(MAP_UARTCharsAvail(UART2_BASE));
SysCtlDelay(8000000/2);
     while(MAP_UARTCharsAvail(UART2_BASE))
                   {

                                                     k=MAP_UARTCharGetNonBlocking(UART2_BASE);
                                                     if(k != "\n")
                                                     dbg_printf("%c", k);
                                                     //k++;

                   }

}
