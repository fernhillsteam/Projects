/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          :
  * // * main.c Initialize and display "hello" on the LCD using 8-bit data mode.
// * The LCD controller is connected to the Nucleo-F446RE
// * board as follows:
// *
// * PC0-PC7 for LCD D0-D7, respectively.
// * PB5 for LCD R/S
// * PB6 for LCD R/W
// * PB7 for LCD EN
  ******************************************************************************
  * @attention
  *
  * <h2><center>&copy; Copyright (c) 2021 STMicroelectronics.
  * All rights reserved.</center></h2>
  *
  * This software component is licensed by ST under BSD 3-Clause license,
  * the "License"; You may not use this file except in compliance with the
  * License. You may obtain a copy of the License at:
  *                        opensource.org/licenses/BSD-3-Clause
  *
  ******************************************************************************
  */

#include "stm32f4xx.h"

#define RS 0x20     /* PB5 mask for reg select */
#define RW 0x40     /* PB6 mask for read/write */
#define EN 0x80     /* PB7 mask for enable */

void delayMs(int n);
void LCD_command(unsigned char command);
void LCD_data(char data);
void LCD_init(void);
void PORTS_init(void);

int main(void)
{
    /* initialize LCD controller */
    LCD_init();

    while(1)
    {
        /* Write "hello" on LCD */
        LCD_data('F');
        LCD_data('E');
        LCD_data('R');
        LCD_data('N');
        LCD_data('H');
        LCD_data('I');
        LCD_data('L');
        LCD_data('L');
        delayMs(1000);

        /* clear LCD display */
        LCD_command(1);
        delayMs(500);
    }
}

/* initialize port pins then initialize LCD controller */
void LCD_init(void)
{
    PORTS_init();

    delayMs(30);            /* initialization sequence */
    LCD_command(0x30);
    delayMs(10);
    LCD_command(0x30);
    delayMs(1);
    LCD_command(0x30);

    LCD_command(0x38);      /* set 8-bit data, 2-line, 5x7 font */
    LCD_command(0x06);      /* move cursor right after each char */
    LCD_command(0x01);      /* clear screen, move cursor to home */
    LCD_command(0x0F);      /* turn on display, cursor blinking */
}

void PORTS_init(void)
{
    RCC->AHB1ENR |=  0x06;          /* enable GPIOB/C clock */

    /* PB5 for LCD R/S */
    /* PB6 for LCD R/W */
    /* PB7 for LCD EN */
    GPIOB->MODER &= ~0x0000FC00;    /* clear pin mode */
    GPIOB->MODER |=  0x00005400;    /* set pin output mode */
    GPIOB->BSRR = 0x00C00000;       /* turn off EN and R/W */

    /* PC0-PC7 for LCD D0-D7, respectively. */
    GPIOC->MODER &= ~0x0000FFFF;    /* clear pin mode */
    GPIOC->MODER |=  0x00005555;    /* set pin output mode */
}

void LCD_command(unsigned char command)
{
    GPIOB->BSRR = (RS | RW) << 16;  /* RS = 0, R/W = 0 */
    GPIOC->ODR = command;           /* put command on data bus */
    GPIOB->BSRR = EN;               /* pulse E high */
    delayMs(0);
    GPIOB->BSRR = EN << 16;         /* clear E */

    if (command < 4)
        delayMs(2);         /* command 1 and 2 needs up to 1.64ms */
    else
        delayMs(1);         /* all others 40 us */
}

void LCD_data(char data)
{
    GPIOB->BSRR = RS;               /* RS = 1 */
    GPIOB->BSRR = RW << 16;         /* R/W = 0 */
    GPIOC->ODR = data;              /* put data on data bus */
    GPIOB->BSRR = EN;               /* pulse E high */
    delayMs(0);
    GPIOB->BSRR = EN << 16;         /* clear E */

    delayMs(1);
}

/* delay n milliseconds (16 MHz CPU clock) */
void delayMs(int n)
{
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}


/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
