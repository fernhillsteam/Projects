/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          :
 * User Switch B1 is used to generate interrupt through PC13.
 * The user button is connected to PC13. It has a pull-up resitor
 * so PC13 stays high when the button is not pressed.
 * When the button is pressed, PC13 becomes low.
 * The falling-edge of PC13 (when switch is pressed) triggers an
 * interrupt from External Interrupt Controller (EXTI).
 * In the interrupt handler, the user LD2 is blinked twice.
 * It serves as a crude way to debounce the switch.
 * The green LED (LD2) is connected to PA5.
  ******************************************************************************
  * @attention
  *
  * <h2><center>&copy; Copyright (c) 2021 .
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
    __disable_irq();                    /* global disable IRQs */

    RCC->AHB1ENR |= 4;	                /* enable GPIOC clock */
    RCC->AHB1ENR |= 1;                  /* enable GPIOA clock */
    RCC->APB2ENR |= 0x4000;             /* enable SYSCFG clock */

    /* configure PA5 for LED */
    GPIOA->MODER &= ~0x00000C00;        /* clear pin mode */
    GPIOA->MODER |=  0x00000400;        /* set pin to output mode */

    /* configure PC13 for push button interrupt */
    GPIOC->MODER &= ~0x0C000000;        /* clear pin mode to input mode */

    SYSCFG->EXTICR[3] &= ~0x00F0;       /* clear port selection for EXTI13 */
    SYSCFG->EXTICR[3] |= 0x0020;        /* select port C for EXTI13 */

    EXTI->IMR |= 0x2000;                /* unmask EXTI13 */
    EXTI->FTSR |= 0x2000;               /* select falling edge trigger */

//    NVIC->ISER[1] = 0x00000100;         /* enable IRQ40 (bit 8 of ISER[1]) */
    NVIC_EnableIRQ(EXTI15_10_IRQn);

    __enable_irq();                     /* global enable IRQs */

    while(1) {
    }
}

void EXTI15_10_IRQHandler(void) {
        GPIOA->BSRR = 0x00000020;   /* turn on green LED */
        delayMs(250);
        GPIOA->BSRR = 0x00200000;   /* turn off green LED */
        delayMs(250);
        GPIOA->BSRR = 0x00000020;   /* turn on green LED */
        delayMs(250);
        GPIOA->BSRR = 0x00200000;   /* turn off green LED */
        delayMs(250);

        EXTI->PR = 0x2000;          /* clear interrupt pending flag */
}

/* 16 MHz SYSCLK */
void delayMs(int n) {
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}

/************************ (C) COPYRIGHT Fernhill technologies *****END OF FILE****/
