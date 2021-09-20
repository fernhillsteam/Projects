/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          : Use DAC to generate sawtooth waveform
 * The DAC is initialized with no buffer or trigger, so every
 * write to the DAC data register will change the analog output.
 * The data is incremented in the loop and written to the DAC.
 * The output of DAC is on pin PA4.
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
    int data;
    RCC->AHB1ENR |=  1;	            /* enable GPIOA clock */
    GPIOA->MODER |=  0x00000300;    /* PA4 analog */
    /* setup DAC */
    RCC->APB1ENR |= 1 << 29;        /* enable DAC clock */
    DAC->CR |= 1;                   /* enable DAC */

    while(1) {
        DAC->DHR12R1 = data++ & 0x0FFF;
    }
}

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
