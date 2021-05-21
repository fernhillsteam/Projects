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
void sendcmd (char *cmd);
unsigned char sendcmdg (char *cmd);
void server_update();
void gen_url();
char* itoa(int num, char* str, int base);
void Gsm_readyf();

#endif /* INC_GSM_H_ */
