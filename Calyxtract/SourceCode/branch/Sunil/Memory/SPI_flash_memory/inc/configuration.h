/*
 * configuration.h
 *
 *  Created on: 12-May-2021
 *      Author: LENOVO
 */

#ifndef INC_CONFIGURATION_H_
#define INC_CONFIGURATION_H_

//Default configuration parameters

#define DEVICE_ID   "A1001"
#define APN         "bsnlnet"
#define MOBIL_NUM   "9845012345"
#define USER_NAME   "SUNIL"
#define PASSWORD    "12345"
#define SERVER_LINK "www.google.com"
#define AUTH_CODE   "001100"

void device_configuration();
void device_config_read();
void mobile_configuration();
void mobile_config_read();

void configuration();
void edit_parameters();
#endif /* INC_CONFIGURATION_H_ */
