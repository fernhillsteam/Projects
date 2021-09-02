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
#include "stdbool.h"

uint8_t digits[10]={0xC0, 0xF9, 0xA4, 0xB0, 0x99, 0x92, 0x82, 0xF8, 0x80, 0x90};
uint8_t ones, tens ;
uint8_t i,j;
bool swap=0;

void delayMs(int n);

int main(void) {
    RCC->AHB1ENR |=  2;             /* enable GPIOB clock */
    RCC->AHB1ENR |=  4;             /* enable GPIOC clock */

    GPIOC->MODER &= ~0x0000FFFF;    /* clear pin mode */
    GPIOC->MODER |=  0x00005555;    /* set pins to output mode */
    GPIOB->MODER &= ~0x0000000F;    /* clear pin mode */
    GPIOB->MODER |=  0x00000005;    /* set pins to output mode */

    /* setup TIM2 */
       RCC->APB1ENR |= 1;              /* enable TIM2 clock */
       TIM2->PSC = 1600 - 1;          /* divided by 16000 */
       TIM2->ARR = 1000 - 1;           /* divided by 1000 */
       TIM2->CR1 = 1;                  /* enable counter */

       TIM2->DIER |= 1;                /* enable UIE */
       NVIC_EnableIRQ(TIM2_IRQn);      /* enable interrupt in NVIC */

       __enable_irq();                 /* global enable IRQs */


    for(;;)
    {
    	for(i=0;i<10;i++)
    	{
    		for(j=0;j<10;j++)
    		{
    			ones++;
    			delayMs(100);
//    			 	 	GPIOC->ODR = ~(digits[tens]);            /* display tens digit */
//    			        GPIOB->BSRR = 0x00010000;       /* deselect ones digit */
//    			        GPIOB->BSRR = 0x00000002;       /* select tens digit */
//    			        delayMs(50);
//    			        GPIOC->ODR = ~(digits[ones]);            /* display ones digit */
//    			        GPIOB->BSRR = 0x00020000;       /* deselect tens digit */
//    			        GPIOB->BSRR = 0x00000001;       /* select ones digit */
//    			        delayMs(50);
    		}
    		tens++;
    		if(ones == 10 )
    		{ones = 0;}
    	}
    	if(tens == 10 )
    	    {tens = 0;}

    }
}

/* 16 MHz SYSCLK */
void delayMs(int n) {
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}

void TIM2_IRQHandler(void)
{
    TIM2->SR = 0;                   /* clear UIF */
  (swap == 0)? (swap = 1):( swap = 0);

  if(swap == 0)
  {
	  GPIOC->ODR = ~(digits[tens]);            /* display tens digit */
	  GPIOB->BSRR = 0x00010000;       /* deselect ones digit */
	  GPIOB->BSRR = 0x00000002;       /* select tens digit */
  }
  else if(swap == 1)
  {
	  GPIOC->ODR = ~(digits[ones]);            /* display ones digit */
	  GPIOB->BSRR = 0x00020000;       /* deselect tens digit */
	  GPIOB->BSRR = 0x00000001;       /* select ones digit */

  }
}
/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
