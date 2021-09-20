/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          :
// * main.c Turn on or off LED by a switch
// * This program turns on the green LED (LD2) by pressing the user
// * button B1 of the STM32F401RE.
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

int main(void) {
    RCC->AHB1ENR |=  4;                 /* enable GPIOC clock */
    RCC->AHB1ENR |=  1;                /* enable GPIOA clock */

    GPIOA->MODER &= ~0x00000C00;        /* clear pin mode */
    GPIOA->MODER |=  0x00000400;        /* set pin to output mode */

    GPIOC->MODER &= ~0x0C000000;        /* clear pin mode to input mode */

    while(1) {
        if (GPIOC->IDR & 0x2000)        /* if PC13 is high */
            GPIOA->BSRR = 0x00200000;   /* turn off green LED */
        else
            GPIOA->BSRR = 0x00000020;   /* turn on green LED */
    }
}

/************************ (C) COPYRIGHT Fernhill technologies *****END OF FILE****/
