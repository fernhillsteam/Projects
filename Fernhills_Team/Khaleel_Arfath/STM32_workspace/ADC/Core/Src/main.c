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

char Temperature[100] ={0};

void Clock_Config(){						//HSI CLOCK 16MHz
	RCC->CR		|=	RCC_CR_HSION;			// Enable HSI
	while(!(RCC->CR & RCC_CR_HSIRDY));		// Wait till HSI READY
}

void USART_6(){
	RCC->AHB1ENR 	|= 	RCC_AHB1ENR_GPIOCEN; 			// Enable clock for GPIOC
	RCC->APB2ENR	|= 	RCC_APB2ENR_USART6EN;   		// Enable clock for USART6
	GPIOC->AFR[0]	 =	0x88000000;  					// enable USART6_TX to PC6 and USART6_RX to PC7
	GPIOC->MODER	|=	GPIO_MODER_MODER6_1;			// configuring the USART6 ALTERNATE function PC6
	GPIOC->MODER	|=	GPIO_MODER_MODER7_1;				// configuring the USART6 ALTERNATE function PC7
	USART6->BRR		 =	0x682;    						// 9600 Baud
	USART6->CR1		|=	USART_CR1_UE |USART_CR1_TE|USART_CR1_RE|USART_CR1_RXNEIE; 	// USART6 enable(c=[TE: Transmitter enable %RE:Receiver enable]2=[RXNEIE:RXNE interrupt enable]2=[UE: USART enable] )
}

void SendChar(char Tx){
   while(!(USART6->SR & USART_SR_TXE));  			// wait TXBUFF=1
   USART6->DR=Tx;
}

void SendTxt(char *Adr)
{
  while(*Adr){
    SendChar(*Adr);
    Adr++;
  }
}

void Config_ADC()//PA0 and PA1 & PA2
{
	RCC->APB2ENR |= RCC_APB2ENR_ADC1EN ;//| RCC_APB2ENR_ADC2EN | RCC_APB2ENR_ADC3EN; // Enable ADC1 ,ADC2, ADC3
	RCC->AHB1ENR |= RCC_AHB1ENR_GPIOAEN; //clock enable GPIOA
	ADC->CCR = ADC_CCR_MULTI_1 | ADC_CCR_MULTI_2 ; // No DMA, Regular simultaneous mode only

	ADC1->CR2 = ADC_CR2_ADON; // Control Register 2: ADC1 ON
	ADC1->SQR3 = 0; // regular SeQuence Register 3

//	ADC2->CR2 = ADC_CR2_ADON; // Control Register 2: ADC2 ON
//	ADC2->SQR3 = ADC_SQR3_SQ1_0; // regular SeQuence Register 3
//
//	ADC3->CR2 = ADC_CR2_ADON; // Control Register 2: ADC3 ON
//	ADC3->SQR3 = ADC_SQR3_SQ1_1 ; // regular SeQuence Register 3

	GPIOA->MODER |= GPIO_MODER_MODER0_0 |GPIO_MODER_MODER0_1 |GPIO_MODER_MODER1_0 | GPIO_MODER_MODER1_1 | GPIO_MODER_MODER2_0 |GPIO_MODER_MODER2_1 ;//Analog mode PA0 and PA1 & PA2
}

unsigned char LM35_Read(){
	ADC1->CR2 |= ADC_CR2_SWSTART; // simultaneous Start Conversion
	while(!(ADC1->SR & 0x2)); // wait for ADC1 conversion to complete
	int temp =	ADC1->DR;
	unsigned char temperature =(temp*100)*(3.3/4095);//4095 ADC 12 bits(2^12-1)
	return temperature;
}

int main(void){
	Clock_Config();
	Config_ADC();
	USART_6();

	while(1)
	{
		sprintf(Temperature," LM35= %d\n\n",LM35_Read()) ;
		SendTxt(Temperature);

	}
}

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
