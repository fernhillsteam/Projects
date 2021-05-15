/*
 * global.h
 *
 *  Created on: Mar 23, 2021
 *      Author: Admin
 */

#ifndef INC_GLOBAL_H_
#define INC_GLOBAL_H_

#include <stdint.h>
#include <stdbool.h>
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
#include "driverlib/timer.h"

#define EVAL_BRD_LED 1  //to activate the EVAL board inbuilt led's PN0 &PN1

//****************************************************************************
//
// System clock rate in Hz.
//
//****************************************************************************
uint32_t g_ui32SysClock;


//URL and Api key for the server

//#define api_key "api_key=SCZTUL09JSNVP3F0"
#define time "07-04-2021_17:02"

////AC Variables
//uint32_t uint32_tac_v, uint32_tac_c, uint32_tac_p ;
////DC Variables
//uint32_t uint32_tdc_v, uint32_tdc_c,uint32_tdc_p ;
//Time stamp variable
//unsigned char tmstmp[64]= ""; //"\{\"Current_date\" : \"2021-03-25\", \"current_time\" : \"17-30\"\}";   //{"Current_date" : "yyyy-mm-dd", "current_time : "hh-mm"}

void convert(uint32_t digit);

#endif /* INC_GLOBAL_H_ */
