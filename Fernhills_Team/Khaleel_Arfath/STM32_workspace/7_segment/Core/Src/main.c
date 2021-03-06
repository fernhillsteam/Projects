/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          : // * main.c Display number 75 on a 2-digit 7-segment common cathode LED.
// * The segments are driven by Port C0-C6.
// * The digit selects are driven by PB0 and PB1.
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

void delayMs(int n);

int main(void) {
    RCC->AHB1ENR |=  2;             /* enable GPIOB clock */
    RCC->AHB1ENR |=  4;             /* enable GPIOC clock */

    GPIOC->MODER &= ~0x0000FFFF;    /* clear pin mode */
    GPIOC->MODER |=  0x00005555;    /* set pins to output mode */
    GPIOB->MODER &= ~0x0000000F;    /* clear pin mode */
    GPIOB->MODER |=  0x00000005;    /* set pins to output mode */

    for(;;)
    {
        GPIOC->ODR = 0x007F;            /* display tens digit */
        GPIOB->BSRR = 0x00010000;       /* deselect ones digit */
        GPIOB->BSRR = 0x00000002;       /* select tens digit */
        delayMs(50);
        GPIOC->ODR = 0x0007;//0x006D;            /* display ones digit */
        GPIOB->BSRR = 0x00020000;       /* deselect tens digit */
        GPIOB->BSRR = 0x00000001;       /* select ones digit */
        delayMs(50);
    }
}

/* 16 MHz SYSCLK */
void delayMs(int n) {
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}


/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
