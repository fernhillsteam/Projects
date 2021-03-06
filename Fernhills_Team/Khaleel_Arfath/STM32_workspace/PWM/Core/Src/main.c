/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          : Main program body
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

void Clock_Config(){						//HSI CLOCK 16MHz
	RCC->CR		|=	RCC_CR_HSION;			// Enable HSI
	while(!(RCC->CR & RCC_CR_HSIRDY));		// Wait till HSI READY
}

void Config_PWM(){
	RCC->APB1ENR |= RCC_APB1ENR_TIM3EN; //clock enable for TIM3
	RCC->AHB1ENR |= RCC_AHB1ENR_GPIOAEN; //clock enable GPIOA
	GPIOA->MODER |= GPIO_MODER_MODER6_1; //Alternative function mode PA6
	TIM3->CCMR1 = TIM_CCMR1_OC1M_1 |TIM_CCMR1_OC1M_2; //PWM mode 1 on TIM3 Channel 1
	TIM3->PSC = 2;   // Fc=f/PSC+1    avec  f=16Mhz;; ARR=256;; =Fc/256
	TIM3->ARR = 255;
	TIM3->CCR1 = 0;
	GPIOA->AFR[0] = 0x2000000; //set GPIOA to AF2
	TIM3->CCER	|=TIM_CCER_CC1E;
	//TIM3->EGR	|=TIM_EGR_CC1G;//enable interrupt
	TIM3->CR1 	 = TIM_CR1_CEN; //enable counter of tim3

}

int main(void){
	Clock_Config();
	Config_PWM();

	while(1){
			TIM3->CCR1++;
			if(TIM3->CCR1==TIM3->ARR)
			{
				TIM3->CCR1=0;
			}
	}
	return 0 ;
}

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
