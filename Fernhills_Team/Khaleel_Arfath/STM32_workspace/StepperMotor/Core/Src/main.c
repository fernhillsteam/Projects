/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          : This program controls a unipolar stepper motor using PTA7, 6, 5, 4.
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
//    const char steps[ ] = {0x90, 0x30, 0x60, 0xC0};
//    int i;

    /* PTA7, 6, 5, 4 for motor control */
    RCC->AHB1ENR |=  1;	            /* enable GPIOA clock */
    GPIOA->MODER &= ~0x0000FF00;    /* clear pin mode */
    GPIOA->MODER |=  0x00005500;    /* set pins to output mode */

    for (;;) {


    	GPIOA->ODR |= (1<<4)|(1<<7);  /* turn on LED */
    	GPIOA->ODR &= ~((1<<5)|(1<<6));  /* turn off LED */
    	delayMs(500);
    	GPIOA->ODR |= (1<<4)|(1<<5);  /* turn on LED */
    	GPIOA->ODR &= ~((1<<7)|(1<<6));  /* turn off LED */
    	delayMs(500);
    	GPIOA->ODR |= (1<<5)|(1<<6);  /* turn on LED */
    	GPIOA->ODR &= ~((1<<4)|(1<<7));  /* turn off LED */
    	delayMs(500);
    	GPIOA->ODR |= (1<<6)|(1<<7);  /* turn on LED */
    	GPIOA->ODR &= ~((1<<5)|(1<<4));  /* turn off LED */
    	delayMs(500);
    }
}
/* 16 MHz SYSCLK */
void delayMs(int n) {
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}


/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
