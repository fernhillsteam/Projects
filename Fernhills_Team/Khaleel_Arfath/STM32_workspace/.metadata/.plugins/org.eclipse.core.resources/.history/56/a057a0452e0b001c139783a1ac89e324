/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          :
// * main.c Toggle Green LED (LD2) on STM32F401RE Nucleo64 board at 1 Hz
// * This program toggles LD2 for 0.5 second ON and 0.5 second OFF
// * The green LED (LD2) is connected to PA5.
// * This program toggles LD2 for 0.5 second ON and 0.5 second OFF
// * by writing a '1' to bit 5 or bit 21 of the Bit Set/Reset  Register (BSRR).
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
    RCC->AHB1ENR |=  1;             /* enable GPIOA clock */

    GPIOA->MODER &= ~0x00000C00;    /* clear pin mode */
    GPIOA->MODER |=  0x00000400;    /* set pin to output mode */

    while(1) {
        GPIOA->BSRR = 0x00000020;   /* turn on LED */
        delayMs(500);
        GPIOA->BSRR = 0x00200000;   /* turn off LED */
        delayMs(500);
    }
}

/* 16 MHz SYSCLK */
void delayMs(int n) {
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}

/************************ (C) COPYRIGHT Fernhill technologies *****END OF FILE****/
