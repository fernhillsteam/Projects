/*
 * GSM.h
 *
 *  Created on: Mar 17, 2021
 *      Author: Admin
 */

#ifndef INC_GSM_H_
#define INC_GSM_H_

void GSM_init();
void GPRS_init();
//void connectGSM (char *cmd, char *res);
//int GSMgetResponse(char *expResponse);
void GSMread();
char response_check(char *buf);
char sendcmd (char *cmd);
void sendcmdg (char *cmd);
void readAction(char *cmd);
void readresponse (char *cmd);
char response_grab(char *buf);
void server_update();
void OV_update();
void SC_update();
void reset_led_update();
void GSM_gen_url();
char* GSM_gen_APN();


unsigned char response[200];
char itoa[50];

#define atapn1 "AT+SAPBR=3,1,\"APN\",\""

#endif /* INC_GSM_H_ */
