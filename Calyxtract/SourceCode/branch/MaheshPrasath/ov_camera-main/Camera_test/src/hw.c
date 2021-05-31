/*
 * hw.c
 *
 *  Created on: Jan 20, 2021
 *      Author: Admin
 */
#include <stdint.h>
#include <stdbool.h>

#define TARGET_IS_TM4C129_RA1

#include "inc/hw_i2c.h"
#include "inc/hw_memmap.h"
#include "inc/hw_types.h"
#include "inc/hw_pwm.h"
#include "inc/hw_udma.h"
#include "inc/hw_ints.h"
#include "inc/hw_timer.h"
#include "driverlib/pin_map.h"
#include "driverlib/i2c.h"
#include "driverlib/pwm.h"
#include "driverlib/gpio.h"
#include "driverlib/sysctl.h"
#include "driverlib/uart.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/interrupt.h"
#include "driverlib/udma.h"
#include "driverlib/timer.h"
#include "inc/ov7725.h"
//#include "inc/hw.h"

#include "inc/RS_232.h"
#include "inc/dbg.h"

#pragma DATA_ALIGN(dma_table, 1024)
static uint8_t dma_table[1024];
uint8_t *img_buffer;

void dma_init(void)
{
    ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_UDMA);

    MAP_uDMAEnable();
    MAP_uDMAControlBaseSet(&dma_table[0]);
    MAP_uDMAChannelAssign(UDMA_CH12_GPIOK);
    uDMAChannelAttributeDisable(UDMA_CH12_GPIOK, UDMA_ATTR_ALL);

    MAP_uDMAChannelControlSet(UDMA_CH12_GPIOK|UDMA_PRI_SELECT,
                                UDMA_SIZE_8|
                                UDMA_SRC_INC_NONE|
                                UDMA_DST_INC_8|
                                UDMA_ARB_1);
#if 0
    MAP_uDMAChannelTransferSet(UDMA_SEC_CHANNEL_UART2RX_12|UDMA_ALT_SELECT,
                            UDMA_MODE_BASIC,
                            &HWREG(GPIO_PORTM_BASE + (0x00U + (0xFFU << 2))),
                            img_buffer,
                            1);

    ROM_uDMAChannelEnable(UDMA_SEC_CHANNEL_UART2RX_12);
#endif

    MAP_uDMAChannelAssign(UDMA_CH6_TIMER2A);
    uDMAChannelAttributeDisable(UDMA_CH6_TIMER2A, UDMA_ATTR_ALL);

    MAP_uDMAChannelControlSet(UDMA_CH6_TIMER2A|UDMA_PRI_SELECT,
                                UDMA_SIZE_16|
                                UDMA_SRC_INC_16|
                                UDMA_DST_INC_NONE|
                                UDMA_ARB_1);
}

void hw_dma_set_img(uint8_t *p_img)
{
    MAP_uDMAChannelTransferSet(UDMA_CH12_GPIOK|UDMA_PRI_SELECT,
                            UDMA_MODE_BASIC,
                            &HWREG(GPIO_PORTM_BASE + (0x00U + (0xFFU << 2))),
                            p_img,
                            320*2);

    ROM_uDMAChannelAttributeEnable(UDMA_CH12_GPIOK, UDMA_ATTR_HIGH_PRIORITY);

    ROM_uDMAChannelEnable(UDMA_CH12_GPIOK);
}

uint8_t hw_is_dma_img_complete(void)
{
    return (MAP_uDMAChannelModeGet(UDMA_CH12_GPIOK) == UDMA_MODE_STOP);
}
