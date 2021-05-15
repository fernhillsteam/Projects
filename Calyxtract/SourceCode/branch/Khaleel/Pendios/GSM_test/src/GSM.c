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

#include "inc/global.h"
#include "inc/Config.h"
#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/GSM.h"
#include "inc/atcommand.h"


char APN_Conf[50]= GPRS_APN;
char apn[100]="";
char url[128] ="";

uint32_t uint32_tac_v=240;
uint32_t uint32_tac_c=5;
uint32_t uint32_tac_p= 1200;
uint32_t uint32_tdc_v=30;
uint32_t uint32_tdc_c=3 ;
uint32_t uint32_tdc_p= 100;


void GSM_init()
{
    //char *at_temp;
    unsigned char response_status=0;

    //at_temp = Gsm_Ready;
    do
    {
            //UARTprintf("AT+CPIN?\n");//ok
            UARTprintf("%s", Gsm_Ready);//ok
            if(response_check("OK"))
                   {
                   dbg_printf("\r\nAT+CPIN?");
                   dbg_printf("\t Success\n");
                   response_status=1;
                   }
    }while(response_status != 1);
    //    sendcmd("AT+CFUN=1\n"); //OK
    //    SysCtlDelay(8000000);

    sendcmdg(Attention); //OK           //ping the modem
    SysCtlDelay(8000000);
    sendcmdg(Auto_Echo_Off); //OK         //echo off
    SysCtlDelay(8000000);
    sendcmdg(GPRS_Detach); //OK   //GPRS Detach
    SysCtlDelay(8000000);
    sendcmdg(GPRS_Attach); //OK   //GPRS Attach
    SysCtlDelay(8000000);

    dbg_printf("\r\nGSM initiated!!!\n");
}

void GPRS_init()
{

        sendcmdg(GPRS_Connection_type);//OK
        SysCtlDelay(8000000);
        //sendcmdg("AT+SAPBR=3,1,\"APN\",\"bsnlnet\"\n");//OK
        sendcmdg(GSM_gen_APN());
        SysCtlDelay(8000000);
//        sendcmdg("AT+SAPBR=0,1\n");//OK
//               SysCtlDelay(8000000);
        sendcmdg("AT+SAPBR=1,1\n");//OK
        SysCtlDelay(8000000);
//        sendcmdg("AT+SAPBR=2,1\n");//OK
//        SysCtlDelay(8000000);
//        sendcmdg("AT+HTTPINIT\n"); //OK
//        SysCtlDelay(8000000);

        dbg_printf("\r\nGPRS Initiated\n");
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
  int i=0;
  char x = 0;
  for(i=0;buf[i]!='\0';i++)
  {
    do
    {
      if(MAP_UARTCharsAvail(UART2_BASE)>0)
      {
        x=MAP_UARTCharGetNonBlocking(UART2_BASE);
//        response[g]=x; g++;
//        MAP_UARTCharPutNonBlocking(UART0_BASE,x);
      }
    }while((x != buf[i]));
    //buf++;
  }
  return 1;
}

char sendcmd (char *cmd)
{   uint8_t char_count=0,i=0;
    char buffer[100];

   // UARTprintf("%s", cmd);
    for(char_count=0;char_count<=strlen(cmd);char_count++)
        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);
    SysCtlDelay(8000000);

//    if(response_check("OK"))
//        {
//        dbg_printf("%s",cmd);
//        dbg_printf(" Success\n");
//        }
//    if(MAP_UARTCharsAvail(UART2_BASE)>0){
//
//    do
//    {
//
//        x=MAP_UARTCharGetNonBlocking(UART2_BASE);
//        buffer[j]=x;
//        dbg_printf("%c",buffer[j]);
//        j++;
//    }while(x!='\r');
//    }

//    do{
//    for( i = 0 ; MAP_UARTCharsAvail(UART2_BASE)>0 && i<200 ; i++) {
//        buffer[i] = MAP_UARTCharGetNonBlocking(UART2_BASE);
//        MAP_UARTCharPutNonBlocking(UART2_BASE,buffer[i]);
//    }
//
//    }while(buffer[i]== 'K');

    for( i = 0 ; MAP_UARTCharsAvail(UART2_BASE)>0 && i<200 ; i++) {
           buffer[i] = MAP_UARTCharGetNonBlocking(UART2_BASE);

       }
    dbg_printf("\r\n%s",cmd);
    dbg_printf("\r\n%s",buffer);


    if(strstr(buffer, "OK"))
    {
        dbg_printf("\r\nsuccess");
        return 1;
    }
    else if (strstr(buffer, "ERROR"))
    {
        dbg_printf("\r\nerror");
        return 0;
    }
    else
    {
        dbg_printf("\r\nNo response");
    }
    return 2;
}

void sendcmdg (char *cmd)
{

    UARTprintf("%s", cmd);
//    for(char_count=0;char_count<=strlen(cmd);char_count++)
//        MAP_UARTCharPutNonBlocking(UART2_BASE,cmd[char_count]);

    //MAP_UARTCharPutNonBlocking(UART2_BASE,0x0D);
    SysCtlDelay(8000000/2);
    if(response_check("OK"))
        {
        dbg_printf("\r\n%s",cmd);
        dbg_printf("\tSuccess\n");

        }

}

/*
 * This function reads the response from the HTTPACTION command
 * */
void readAction(char *cmd)
{
    UARTprintf("%s", cmd);
    if(response_grab("+"))
        {
        dbg_printf("\r\n%s",cmd);
        dbg_printf("\tSuccess\n");
        }
}


/*
 * This function reads the response from the HTTP server on sending the HTTPREAD command
 * */
void readresponse (char *cmd)
{
    UARTprintf("%s", cmd);

    if(response_grab("OK"))
        {
        dbg_printf("\r\n%s",cmd);
        dbg_printf("\r\nREAD SUCCESS\n");

        }
}

char response_grab(char *buf)
{
  int i=0,g=0;char x = 0;
  for(i=0;buf[i]!='\0';i++)
  {
    do
    {
      if(MAP_UARTCharsAvail(UART2_BASE)>0)
      {
        x=MAP_UARTCharGetNonBlocking(UART2_BASE);
        response[g]=x; g++;
        //MAP_UARTCharPutNonBlocking(UART0_BASE,x);
      }
    }while((x != buf[i]));
    //buf++;
  }
  return 1;
}
////////////////////////////////////////////////////////////////////////////////////////


//void GSMread()
//{   char k;
//    SysCtlDelay(8000000/2);
//     while(MAP_UARTCharsAvail(UART2_BASE))
//                   {
//
//                                                     k=MAP_UARTCharGetNonBlocking(UART2_BASE);
//                                                     if(k != "\n")
//                                                     dbg_printf("%c", k);
//
//                   }
//}


void server_update()
{ unsigned char status = 'u';;
    dbg_printf("\nSERVER entered\n");
    //GSM_gen_url();

    if(sendcmd("AT+HTTPINIT\n")) //http initialised
    {
        dbg_printf("\r\nHttp Initialized");
    }
    else if (sendcmd("AT+HTTPTERM\n")) //if http is already open, terminate the connection
    {
        dbg_printf("Http Terminated");
        if(sendcmd("AT+HTTPINIT\n"))   //Re-initialise the http connection
            {
                dbg_printf("Http Re-Initialized");
            }
    }

    sendcmdg("AT+HTTPPARA=\"CID\",1\n"); //OK
    SysCtlDelay(8000000);

    switch(status)
    {

    case 'u':       //Upload the parameters to the databsae
    GSM_gen_url();
    //sendcmdg("AT+HTTPPARA=\"URL\",\"api.thingspeak.com/update?api_key=SCZTUL09JSNVP3F0&field1=240&filed2=3&field3=31&field4=45&field5=8.30\"\n"); //OK
    //sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter/insert_db2.php?time=29-04-2021_20:00&ac_v=240&ac_c=10&ac_p=2400&dc_v=22&dc_c=10&dc_p=100\"\n"); //OK
    sendcmdg(url);
    SysCtlDelay(8000000);
    break;

    case 'i':       //update the indicator value based on the fault detected
    sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter-0.1/voltmeter/indicator_insert.php?sc=1&st=0&ov=0&tp=0&hl=1\"\n"); //OK
    SysCtlDelay(8000000);
    break;

    case 'b':       //Fetch the button status and perform the suitable action
    sendcmdg("AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter/fetch_button.php\"\n"); //OK
    SysCtlDelay(8000000);
    break;

    }
    readAction("AT+HTTPACTION=0\n"); //OK

//#define DebugPrint
    dbg_printf("\r\nresponse = %s",response);
//#endif

    SysCtlDelay(8000000);

    readresponse("AT+HTTPREAD\n"); //OK
    dbg_printf("\r\nresponse = %s",response);

    sendcmd("AT+HTTPTERM\n"); //OK
    SysCtlDelay(8000000);


    dbg_printf("\nSERVER UPDATED\n");
}


/*
 * This function generates the APN format required to set the
 * GPRS connection for the current inserted SIM card. Current
 * the APN format with AT command is :
 * AT+SAPBR=3,1,"bsnlnet"
 * */
char*  GSM_gen_APN()
{
     char *at_temp;

    at_temp = atapn1;
    //strcpy(apn,"AT+SAPBR=3,1,\"APN\",\"");
    strcpy(apn,at_temp);
    strcat(apn, "bsnlnet");
    //strcat(apn,"\"\n");
    dbg_printf("%s",apn);
    return apn;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////


/*
 * This function generates the URL to upload the ac and dc parameters
 * by introducing the parameters into a proper url format. The example
 * format will be:
 *  "http://imbrutetechnologies.com/pwa/voltmeter/insert_db2.php?time=29-04-2021_20:00&ac_v=240&ac_c=10&ac_p=2400&dc_v=22&dc_c=10&dc_p=100"
 * */
void GSM_gen_url()
{

//unsigned char* c_ac_v="",c_ac_c="",c_ac_p="",c_dc_v="",c_dc_c="",c_dc_p="";


strcpy(url,"AT+HTTPPARA=\"URL\",\"");
strcat(url,api);
strcat(url,"time=");
strcat(url, "18:02");
strcat(url,"&ac_v=");
convert(uint32_tac_v);
strcat(url,itoa);
strcat(url,"&ac_c=");
convert(uint32_tac_c);
strcat(url,itoa);
strcat(url,"&ac_p=");
convert(uint32_tac_p);
strcat(url,itoa);
strcat(url,"&dc_v=");
convert(uint32_tdc_v);
strcat(url,itoa);
strcat(url,"&dc_c=");
convert(uint32_tdc_c);
strcat(url,itoa);
strcat(url,"&dc_p=");
convert(uint32_tdc_p);
strcat(url,itoa);
strcat(url,"\"");
strcat(url,"\n");

//dbg_printf("\r%s",url);
//dbg_printf("\r\ndigit = %s",itoa);

}
/////////////////////////////////////////////////////////////////////////////////////////




//unsigned char* convert(uint32_t digit, unsigned char temp[10])
//{
//    temp[10]=0;
//    unsigned int res=0,y=0;
//
//    dbg_printf("\rresult=%d",digit);
//    //dbg_printf("digit = %d",uint32_tac_v);
///*
//    res=digit/1000;
//    digit%=1000;
//    dbg_printf("\rresult=%d",res);
//    temp[y++]=0x30+res;
//    dbg_printf("\rchar=%c",temp[0]);
//*/
//    res=digit/100;
//    digit%=100;
//    //dbg_printf("\rresult=%d",res);
//    temp[y++]=0x30+res;
//    //dbg_printf("\rchar=%c",temp[0]);
//
//
//    res=digit/10;
//    //dbg_printf("\rresult=%d",res);
//    temp[y++]=0x30+res;
//    //dbg_printf("\rchar=%c",temp[1]);
//
//    res=digit%10;
//    //dbg_printf("\rresult=%d",res);
//    temp[y++]=0x30+res;
//    //dbg_printf("\rchar=%c",temp[2]);
//
//    dbg_printf("\rresult=%s",temp);
//
//    return temp;
//}
////////////////////////////////////////////////////////////////////////////////////////////////////


//void ftoa(float n, char* res, int afterpoint)
//{
//    // Extract integer part
//    int ipart = (int)n;
//
//    // Extract floating part
//    float fpart = n - (float)ipart;
//
//    // convert integer part to string
//    int i = intToStr(ipart, res, 0);
//
//    // check for display option after point
//    if (afterpoint != 0) {
//        res[i] = '.'; // add dot
//
//        // Get the value of fraction part upto given no.
//        // of points after dot. The third parameter
//        // is needed to handle cases like 233.007
//        fpart = fpart * pow(10, afterpoint);
//
//        intToStr((int)fpart, res + i + 1, afterpoint);
//    }
//}

/*
 * This function converts the integer to char/ascii
 *
 * Example : convert(240, *buff);
 * */
void convert(uint32_t digit)
{
        // itoa[50];
        unsigned int res=0,y=0;

        //dbg_printf("\r\nresult=%d",digit);

            res=digit/1000;
            digit%=1000;
            //dbg_printf("\rresult=%d",res);
            itoa[y++]=0x30+res;
            //dbg_printf("\rchar=%c",temp[0]);

            res=digit/100;
            digit%=100;
            //dbg_printf("\rresult=%d",res);
            itoa[y++]=0x30+res;
            //dbg_printf("\r\nchar=%c",temp[0]);


            res=digit/10;
            //dbg_printf("\rresult=%d",res);
            itoa[y++]=0x30+res;
            //dbg_printf("\r\nchar=%c",temp[1]);

            res=digit%10;
            //dbg_printf("\rresult=%d",res);
            itoa[y++]=0x30+res;
            //dbg_printf("\r\nchar=%c",temp[2]);

            //dbg_printf("\r\nstring=%s",itoa);
//return temp;
}
