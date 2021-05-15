/*
 * atcommand.h
 *
 *  Created on: May 7, 2021
 *      Author: Admin
 */

#ifndef INC_ATCOMMAND_H_
#define INC_ATCOMMAND_H_

/*
 * These are the GSM Initialization commands to
 * perform basic gsm operations
 * */
#define Gsm_Ready     "AT+CPIN?\n"
#define Attention     "AT\r"
#define Auto_Echo_Off "ATE0\n"
#define GPRS_Detach   "AT+CGATT=0\n"
#define GPRS_Attach   "AT+CGATT=1\n"


/*
 * These are the GPRS initialization commands to attach
 * the http connection, POST and GET data, Terminate the
 * http connection
 * */
#define GPRS_Connection_type  "AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"\n"
#define Attach_Bearer "AT+SAPBR=1,1\n"
#define Detach_Bearer "AT+SAPBR=0,1\n"



#endif /* INC_ATCOMMAND_H_ */
