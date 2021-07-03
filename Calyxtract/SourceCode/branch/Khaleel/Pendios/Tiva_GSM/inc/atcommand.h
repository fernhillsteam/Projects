/*
 * atcommand.h
 *
 *  Created on: May 18, 2021
 *      Author: yallo
 */

#ifndef INC_ATCOMMAND_H_
#define INC_ATCOMMAND_H_

#define Gsm_ready     "AT+CPIN?\n"
#define Attention     "AT\n"
#define Auto_Echo_Off "ATE0\n"
#define Msg_format    "AT+CMGF=1\n"
#define GPRS_Detach   "AT+CGATT=0\n"
#define GPRS_Attach   "AT+CGATT=1\n"

#define Contype       "AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"\n"
#define Apn           "AT+SAPBR=3,1,\"APN\",\"bsnlnet\"\n"
#define Bearer        "AT+SAPBR=1,1\n"

#define Httpinit      "AT+HTTPINIT\n"
#define Httpterm      "AT+HTTPTERM\n"
#define ContextID     "AT+HTTPPARA=\"CID\",1\n"
//#define URL           "AT+HTTPPARA=\"URL\",\"http://imbrutetechnologies.com/pwa/voltmeter/insert_db2.php?time=10-04-2021_18:42&ac_v=220&ac_c=10&ac_p=2300&dc_v=24&dc_c=10&dc_p=240\"\n"
#define Httpurl       "AT+HTTPPARA=\"URL\",\""
#define Httpaction    "AT+HTTPACTION=0\n"
#define Httpread      "AT+HTTPREAD\n"


/////////////////////////////
//At command functions

uint8_t Gsm_Upready();
uint8_t Gsm_Attention();
uint8_t Gsm_EchoOff();
uint8_t Gsm_msg_format();
uint8_t Gsm_packet_attach();
uint8_t Gsm_packet_detach();
uint8_t Gsm_contype();
uint8_t Gsm_apn();
uint8_t Gsm_bearer_attach();
uint8_t Gsm_http_init();
uint8_t Gsm_http_term();
uint8_t Gsm_http_read();
uint8_t Gsm_http_contextid();
uint8_t Gsm_http_action();
uint8_t Gsm_http_read();
char response_grab(char *buf);

char response[500];

#endif /* INC_ATCOMMAND_H_ */
