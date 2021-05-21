/*
 * spi_flash_main.c
 *
 *  Created on: 06-May-2021
 *      Author: Sunil Pawar
 */


#include <stdbool.h>
#include <stdint.h>
#include "inc/hw_ssi.h"
#include "inc/hw_types.h"
#include "driverlib/udma.h"
#include "inc/hw_udma.h"
#include "inc/hw_memmap.h"
#include "driverlib/gpio.h"
#include "driverlib/pin_map.h"
#include "driverlib/ssi.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "utils/uartstdio.h"

#include "inc/spi_flash.h"
#include "inc/address_mapping.h"
#include "inc/configuration.h"


int main(void)
{
    hardware_init();
    device_information();
    address_mapping();      // to calculate the page, sector and block address
    ControllerFunc();

}


