/*
 * hardware.c
 *
 *  Created on: May 18, 2021
 *      Author: yallo
 */
//#include "inc/include.h"
#include <stdint.h>
#include <stdbool.h>
#include "stdio.h"
#include "stdlib.h"
#include "driverlib/sysctl.h"
#include "utils/uartstdio.h"
#include "inc/GSM.h"
#include "inc/RS_232.h"
#include "inc/dbg.h"

#define uart        1
#define gsm_init    0
#define gprs_init   0



void Configure_clk()
{
        //
        // Set the clocking to run directly from the crystal at 120MHz.
        //
     SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |SYSCTL_OSC_MAIN |SYSCTL_USE_PLL  |SYSCTL_CFG_VCO_480), 120000000);

}


void hw_init()
{
#if uart == 1
    rs232_init(3); // initialise the uart 0 and 2
#endif

#if gsm_init == 1
    GSM_init();
    dbg_printf("\nGSM Initiated\n");
#endif

#if gprs_init == 1
    GPRS_init();
    dbg_printf("\nGPRS Initiated\n");
#endif

    Gsm_readyf();
}
