/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          :
// * Timer TIM2 is configured as an up-counter. By default, the system clock is
// *  running at 16 MHz.The prescaler is set to divide by 16,000 that gives a
// *  1 kHz clock to the counter.The counter auto-reload is set to 999. When
// *  the counter counts to 999, it updates the counter to zero and sets the
// *  update interrupt flag (UIF). The UIE bit of TIM2->DIER is set so that
// *  the UIF triggers a timer interrupt. The interrupt frequency is 1 Hz.
// *  In the timer interrupt handler, the green LED (PA5) is toggled and the UIF is cleared.
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

int main(void)
{
    __disable_irq();                /* global disable IRQs */
    RCC->AHB1ENR |=  1;	            /* enable GPIOA clock */

    GPIOA->MODER &= ~0x00000C00;
    GPIOA->MODER |=  0x00000400;

    /* setup TIM2 */
    RCC->APB1ENR |= 1;              /* enable TIM2 clock */
    TIM2->PSC = 16000 - 1;          /* divided by 16000 */
    TIM2->ARR = 1000 - 1;           /* divided by 1000 */
    TIM2->CR1 = 1;                  /* enable counter */

    TIM2->DIER |= 1;                /* enable UIE */
    NVIC_EnableIRQ(TIM2_IRQn);      /* enable interrupt in NVIC */

    __enable_irq();                 /* global enable IRQs */

    while(1)
    {}
}

void TIM2_IRQHandler(void)
{
    TIM2->SR = 0;                   /* clear UIF */
    GPIOA->ODR ^= 0x20;				/* toggle LED */
}
/************************ (C) COPYRIGHT Fernhill technologies *****END OF FILE****/
