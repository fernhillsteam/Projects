/*
 * atcommand.c
 *
 *  Created on: May 19, 2021
 *      Author: yallo
 */
//#include "inc/include.h"
#include <stdint.h>
#include <stdbool.h>
#include "stdio.h"
#include "stdlib.h"

#include "inc/atcommand.h"
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"
//
//
//#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/GSM.h"


uint8_t Gsm_Upready()
{
    UARTprintf("AT+CPIN?\n");//ok
               if(response_check("+CPIN"))
                      {
                      //dbg_printf("%s",cmd);
                      dbg_printf("\rGSM Network Ready\n");
                      }
    return 1;
}

uint8_t Gsm_Attention()
{
    UARTprintf(Attention);//ok
               if(response_check("OK"))
                      {
                      //dbg_printf("%s",cmd);
                      dbg_printf("\rGSM is Responding\n");
                      }

    return 1;
}

uint8_t Gsm_EchoOff()
{
    UARTprintf(Auto_Echo_Off);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Echo Off\n");
                          }

    return 1;
}

uint8_t Gsm_msg_format()
{
    UARTprintf(Msg_format);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Message format = Text\n");
                          }

    return 1;
}

uint8_t Gsm_packet_attach()
{
    UARTprintf(GPRS_Attach);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Packet Service Attach\n");
                          }

    return 1;
}

uint8_t Gsm_packet_detach()
{
    UARTprintf(GPRS_Detach);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Packet Service Dettach\n");
                          }

    return 1;
}

uint8_t Gsm_contype()
{
    UARTprintf(Contype);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Contype Set\n");
                          }

    return 1;
}

uint8_t Gsm_apn()
{
    UARTprintf(Apn);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM APN Set\n");
                          }

    return 1;
}

uint8_t Gsm_bearer_attach()
{
    UARTprintf(Bearer);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rGSM Bearer Set\n");
                          }

    return 1;
}

uint8_t Gsm_http_init()
{
    UARTprintf(Httpinit);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\r\nHttp initialized\n");
                          }

    return 1;
}

uint8_t Gsm_http_term()
{
    UARTprintf(Httpterm);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rHttp terminated\n");
                          }

    return 1;
}

uint8_t Gsm_http_contextid()
{
    UARTprintf(ContextID);//ok
                   if(response_check("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rHttp context ID\n");
                          }

    return 1;
}

uint8_t Gsm_http_action()
{
    UARTprintf(Httpaction);//ok
                   if(response_check("+"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rHttp Action = 0\n");
                          }

    return 1;
}

uint8_t Gsm_http_read()
{
    UARTprintf(Httpread);//ok
                   if(response_grab("OK"))
                          {
                          //dbg_printf("%s",cmd);
                          dbg_printf("\rHttp Read Success\n");
                          }

    return 1;
}

//void readresponse (char *cmd)
//{
//    UARTprintf("%s", cmd);
//
//    if(response_grab("OK"))
//        {
//        dbg_printf("\r\n%s",cmd);
//        dbg_printf("\r\nREAD SUCCESS\n");
//
//        }
//}

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
