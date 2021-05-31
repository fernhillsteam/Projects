/*
 * Camera_main.c
 *
 *  Created on: Jan 20, 2021
 *      Author: Admin
 */

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
#include "utils/uartstdio.h"
#include "utils/uartstdio.c"
#include "inc/hw_pwm.h"
#include "driverlib/pwm.h"
#include "driverlib/i2c.h"
#include "driverlib/udma.h"
#include "inc/ov7725.h"
#include "inc/hw.h"
#include "inc/sccb.h"
#include "inc/RS_232.h"
#include "inc/dbg.h"
#include "inc/IFT_LCD_PenColor.h"
#include "inc/IFTSPI2_2LCD.h"

static uint32_t g_ui32SysClock;
uint16_t qvga_frame[320*240];

unsigned int BACK_COLOR, POINT_COLOR;
void clk_init(void)
        {
    g_ui32SysClock = SysCtlClockFreqSet((SYSCTL_XTAL_25MHZ |SYSCTL_OSC_MAIN |SYSCTL_USE_PLL  |SYSCTL_CFG_VCO_480), 120000000);
        }

void isr_init(void)
{
    extern void vsync_handler(void);
    extern void href_handler(void);

    GPIOIntEnable(GPIO_PORTP_BASE, GPIO_INT_PIN_0);
    GPIOIntRegister(GPIO_PORTP_BASE, vsync_handler);
    GPIOIntEnable(GPIO_PORTQ_BASE, GPIO_INT_PIN_0);
    GPIOIntRegister(GPIO_PORTQ_BASE, href_handler);
}

void pwm_init(void)
{
    // Configure IO pins
    ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_PWM0);
    PWMClockSet(PWM0_BASE, PWM_SYSCLK_DIV_1);
    GPIOPinConfigure(GPIO_PF1_M0PWM1);
    GPIOPinTypePWM(GPIO_PORTF_BASE, GPIO_PIN_1);
    MAP_GPIOPadConfigSet(GPIO_PORTF_BASE, GPIO_PIN_1,
                             GPIO_STRENGTH_12MA, GPIO_PIN_TYPE_STD);


    PWMGenConfigure(PWM0_BASE, PWM_GEN_0, PWM_GEN_MODE_DOWN | PWM_GEN_MODE_NO_SYNC);

    PWMGenPeriodSet(PWM0_BASE, PWM_GEN_0, 8);
    PWMPulseWidthSet(PWM0_BASE, PWM_OUT_1, PWMGenPeriodGet(PWM0_BASE, PWM_GEN_0) / 2);
    PWMOutputState(PWM0_BASE, PWM_OUT_1_BIT, true);
    PWMGenEnable(PWM0_BASE, PWM_GEN_0);

//    SysCtlPeripheralEnable(SYSCTL_PERIPH_PWM0);
//    //Control PF0 Ethernet LED for PWM
//    PWMClockSet(PWM0_BASE, PWM_SYSCLK_DIV_1);
//    GPIOPinConfigure(GPIO_PF0_M0PWM0);
//    GPIOPinTypePWM(GPIO_PORTF_BASE, GPIO_PIN_0);
//    MAP_GPIOPadConfigSet(GPIO_PORTF_BASE, GPIO_PIN_0,GPIO_STRENGTH_12MA, GPIO_PIN_TYPE_STD);
//    PWMGenConfigure(PWM0_BASE, PWM_GEN_0, PWM_GEN_MODE_DOWN | PWM_GEN_MODE_NO_SYNC);
//    PWMGenPeriodSet(PWM0_BASE, PWM_GEN_0, 8);
//    PWMPulseWidthSet(PWM0_BASE, PWM_OUT_0, PWMGenPeriodGet(PWM0_BASE, PWM_GEN_0) / 2);
//
//
//    PWMOutputState(PWM0_BASE, PWM_OUT_0_BIT, true);
//    PWMGenEnable(PWM0_BASE, PWM_GEN_0);

}

void i2c_init(void)
{
    SysCtlPeripheralEnable(SYSCTL_PERIPH_I2C5);
    while(!SysCtlPeripheralReady(SYSCTL_PERIPH_I2C5))
        ;

    GPIOPinConfigure(GPIO_PB4_I2C5SCL);
    GPIOPinConfigure(GPIO_PB5_I2C5SDA);

    GPIOPinTypeI2CSCL(GPIO_PORTB_BASE, GPIO_PIN_4);
    GPIOPinTypeI2C(GPIO_PORTB_BASE, GPIO_PIN_5);

    I2CMasterInitExpClk(I2C5_BASE, g_ui32SysClock, false); //data transfer rate is 100kbps
    I2CMasterTimeoutSet(I2C5_BASE, 0xFA);  // 40ms timeout
}

void gpio_init(void)
{


// ------------------------------------------------------------------------

    // D0:D7
    GPIOPinTypeGPIOInput(GPIO_PORTM_BASE, 0xFF);
    //MAP_GPIOPadConfigSet(GPIO_PORTM_BASE, 0xFFU, GPIO_STRENGTH_8MA, GPIO_PIN_TYPE_STD_WPU);

    // VSYNC
    GPIOPinTypeGPIOInput(GPIO_PORTP_BASE, GPIO_PIN_0);
    GPIOPadConfigSet(GPIO_PORTP_BASE, GPIO_PIN_0, GPIO_STRENGTH_8MA, GPIO_PIN_TYPE_STD_WPD);
    GPIOIntTypeSet(GPIO_PORTP_BASE, GPIO_PIN_0, GPIO_RISING_EDGE|GPIO_DISCRETE_INT);
    //GPIOIntEnable(GPIO_PORTP_BASE, GPIO_PIN_0);

    // HREF
    GPIOPinTypeGPIOInput(GPIO_PORTQ_BASE, GPIO_PIN_0);
    GPIOIntTypeSet(GPIO_PORTQ_BASE, GPIO_PIN_0, GPIO_FALLING_EDGE|GPIO_DISCRETE_INT);
    //MAP_GPIOPadConfigSet(GPIO_PORTQ_BASE, GPIO_PIN_0, GPIO_STRENGTH_8MA, GPIO_PIN_TYPE_STD_WPD);

    // PCLK
    GPIOPinTypeGPIOInput(GPIO_PORTK_BASE, GPIO_PIN_0);
    //MAP_GPIOPadConfigSet(GPIO_PORTK_BASE, GPIO_PIN_0, GPIO_STRENGTH_8MA, GPIO_PIN_TYPE_STD_WPU);
    GPIOIntTypeSet(GPIO_PORTK_BASE, GPIO_PIN_0, GPIO_RISING_EDGE);
    GPIODMATriggerEnable(GPIO_PORTK_BASE, GPIO_PIN_0);

    // Reset
    GPIOPinTypeGPIOOutput(GPIO_PORTG_BASE, GPIO_PIN_0);
    GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_0, 0);

    // PWDN
    GPIOPinTypeGPIOOutput(GPIO_PORTG_BASE, GPIO_PIN_1);
    GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_1, GPIO_PIN_1);

    // I2C
    GPIOPinTypeGPIOOutput(GPIO_PORTB_BASE, GPIO_PIN_4|GPIO_PIN_5);
    GPIOPadConfigSet(GPIO_PORTB_BASE, GPIO_PIN_4 | GPIO_PIN_5,
                             GPIO_STRENGTH_12MA, GPIO_PIN_TYPE_STD_WPU);


    dbg_printf("GPIO Initialised\n");
}

void dbg(void)
{
    int i;

    uint32_t c;
    uint8_t cmd[5];
    uint8_t wr_cnt = 0;
    uint8_t rd_cnt = 0;
    bool tmp1 = true;
    uint16_t st1;
    uint16_t st2;

#if 1==0
    while(1)
    {
        ov7725_setup_frame_buf(qvga_frame);
        if(ov7725_detect())
        {
            UpdateFIFO();
            trigger_air_jet();
            dbg_printf("detected\r\n");
        }

        //
        // Check if Encoder Pulses has reached FIFO value
        //
        CheckEncoderPulses();
    }
#endif
//  CheckEncoderPulses();
    while (1)
    {
        uint8_t addr;
        uint8_t val;

        c = ROM_UARTCharGet(UART0_BASE);
        //c = '$';
        switch (c)
        {
            case '@':
               // dbg_printf("Pulses : %X\r\n", TimerValueGet(TIMER0_BASE, TIMER_A));
                break;

            case '^':
                ++wr_cnt;
                break;

            case '*':
                ++rd_cnt;
                break;

            case '$':
                //ov7725_dma_read_frame(qvga_frame);
                ov7725_setup_frame_buf((uint8_t *)qvga_frame);
                while (!ov7725_is_image_acquired())
                    ;
                ROM_GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_1 ,GPIO_PIN_1);
                //if(tmp1 == true)
                {
                    tmp1 = false;
                    uint8_t *ptr = (uint8_t *)qvga_frame;
                    for (i = 0; i < 320*240; i++)
                    {
                        ROM_UARTCharPut(UART0_BASE, ((uint8_t *)ptr)[0]);
                        ROM_UARTCharPut(UART0_BASE, ((uint8_t *)ptr)[1]);
                        ptr += 2;
                    }
                }
                LCD_ImageDisp(qvga_frame);

                dbg_printf("$\r\n");
                ROM_GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_1 ,0);
                break;

            case '#':
                do
                {
                    ov7725_setup_frame_buf((uint8_t *)qvga_frame);
                } while(!ov7725_detect());
                for (i = 0; i < 320*2*240; i++)
                    ROM_UARTCharPut(UART0_BASE, ((uint8_t *)qvga_frame)[i]);
                dbg_printf("$\r\n");
                //UpdateFIFO();
                break;

            case '!':
                //motor_start();
                break;

            case '~':
                //motor_homing();
                break;

            default:
                if (wr_cnt)
                {
                    cmd[wr_cnt-1] = c;
                    if (++wr_cnt > 5)
                    {
                        if (cmd[2] != '=')
                        {
                            wr_cnt = 0;
                        }
                        else
                        {
                            if (cmd[0] > 0x39)
                                addr = (cmd[0] - 0x41 + 0xA) << 4;
                            else
                                addr = (cmd[0] - 0x30) << 4;
                            if (cmd[1] > 0x39)
                                addr |= (cmd[1] - 0x41 + 0xA);
                            else
                                addr |= (cmd[1] - 0x30);

                            if (cmd[3] > 0x39)
                                val = (cmd[3] - 0x41 + 0xA) << 4;
                            else
                                val = (cmd[3] - 0x30) << 4;
                            if (cmd[4] > 0x39)
                                val |= (cmd[4] - 0x41 + 0xA);
                            else
                                val |= (cmd[4] - 0x30);

                            dbg_printf("%02X=%02X\r\n", addr, val);
                            //ov7725_write_reg(addr, val);
                            SCCB0_Write_Reg(addr, val);
                            wr_cnt = 0;
                            rd_cnt = 0;
                        }
                    }
                }
                else
                {
                    wr_cnt = 0;
                }

                if (rd_cnt)
                {
                    cmd[rd_cnt-1] = c;
                    if (++rd_cnt > 3)
                    {
                        if (cmd[0] > 0x39)
                            addr = (cmd[0] - 0x41 + 0xA) << 4;
                        else
                            addr = (cmd[0] - 0x30) << 4;
                        if (cmd[1] > 0x39)
                            addr |= (cmd[1] - 0x41 + 0xA);
                        else
                            addr |= (cmd[1] - 0x30);
                        //val = ov7725_read_reg(addr);
                        val = SCCB0_Read_Reg(addr);
                        dbg_printf("%02X=%02X\r\n", addr, val);
                        rd_cnt = 0;
                        wr_cnt = 0;
                    }
                }
                else
                {
                    rd_cnt = 0;
                }
                break;
        }
    }
}



int
main(void)
{
unsigned int i, kli=0;
//Peripherals initializations
   clk_init();


   rs232_init(3);

   //for (i=0;i<99;i++)
   dbg_printf("Clock Initialised\n");//dbg_printf("UART Initialised \n");

   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOP);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOQ);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOB);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOF);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOK);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOM);
   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOG);

   ROM_SysCtlPeripheralEnable(SYSCTL_PERIPH_GPION);
   GPIOPinTypeGPIOOutput(GPIO_PORTN_BASE, GPIO_PIN_0 );
   GPIOPinTypeGPIOOutput(GPIO_PORTN_BASE, GPIO_PIN_1 );
   pwm_init();
   //dbg_printf("PWM Initialised\n");
   gpio_init();

   isr_init();
   //dbg_printf("ISR Initialised\n");
   //i2c_init();
   SCCB0_Init();
   //dbg_printf("SCCB Initialised\n");
   dma_init();
   //dbg_printf("DMA Initialised\n");
//
//


//    dbg_printf("Homing.\r\n");
//    motor_homing();
//    dbg_printf("Ready.\r\n");

  // OV77255CheckPIDVER();
   ov7725_init();
   dbg_printf("CAMERA Initialised\n");
   ROM_GPIOPinWrite(GPIO_PORTN_BASE, GPIO_PIN_0 ,GPIO_PIN_0);

//while(1)
//{
//    ov7725_setup_frame_buf(qvga_frame); //qvga_frame = 320*240*2
//            if(ov7725_detect())
//            {
//               // UpdateFIFO();
//               // trigger_air_jet();
//                dbg_printf("detected\r\n");
//            }
//                    do
//                    {
//                        ov7725_setup_frame_buf(qvga_frame);
//                    } while(!ov7725_detect());
//                    for (i = 0; i < 320*2*240; i++)
//                        ROM_UARTCharPut(UART0_BASE, qvga_frame[i]);
//                    dbg_printf("$\r\n");

//                    while (!ov7725_is_image_acquired())
//                        ;
//                    for (i = 0; i < 320*2*240; i++)
//                        ROM_UARTCharPut(UART0_BASE, qvga_frame[i]);
//                   // dbg_printf("%X",qvga_frame[i]);
//                    dbg_printf("$\r\n");
//                    while(1);

#ifndef TFTDISP
#define     LongSBar        1
#define     ShortSBar       2
    TivaInit();
    Lcd_Init();
    LCD_ImageDisp(qvga_frame);
    //Battery(10,2);
    LCD_ShowString(10,10,"hello");
    //LCD_ShowNum(220,4,8,2);
//    while(1)
//    {
//
//        SignalBar(kli,WHITE,GREEN,RED,LongSBar);
//        SysCtlDelay(SysCtlClockGet()/50);
//        kli+=2;
//        if(kli>99)
//            kli = 0;
//        LCD_ShowNum(220,4,kli,2);
//        SysCtlDelay(SysCtlClockGet()/200);
//    }

#endif
    dbg();
    while(1) ;
//}

}
