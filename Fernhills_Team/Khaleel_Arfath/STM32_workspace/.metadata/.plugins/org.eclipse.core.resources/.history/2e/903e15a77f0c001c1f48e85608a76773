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

#define RTC_ADDRESS			0X68
#define RTC_REGISTER		0X00

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

void I2C_Config(void){ //I2C on pins PB10<SCL-PB11<SDA
	RCC->AHB1ENR 	|= RCC_AHB1ENR_GPIOBEN ;// Enable Clock GPIOB
	RCC->APB1ENR 	|= RCC_APB1ENR_I2C2EN;// Enable Clock I2C
	GPIOB->AFR[1]  	|= 0x4400;
	GPIOB->MODER	|= GPIO_MODER_MODER10_1 | GPIO_MODER_MODER11_1 ;
	GPIOB->MODER	&= ~(GPIO_MODER_MODER10_0 | GPIO_MODER_MODER11_0) ;
	GPIOB->OTYPER	|= GPIO_OTYPER_OT_10 | GPIO_OTYPER_OT_11 ;
	GPIOB->PUPDR	&= ~(GPIO_PUPDR_PUPDR10_0 |GPIO_PUPDR_PUPDR10_1|GPIO_PUPDR_PUPDR11_0|GPIO_PUPDR_PUPDR11_0);
	I2C2->CR2		|= I2C_CR2_FREQ_4;
	I2C2->CCR		|= 0x50;
	I2C2->TRISE		|= 0x11;
	I2C2->CR1		|= I2C_CR1_PE; //Enable Peripheral
	SendTxt("CONFIG I2C.......\n\n");
}

void I2C_Start(){
	I2C2->CR1		|=I2C_CR1_START;				 //Enable Start Condition
	while(!(I2C2->SR1 & I2C_SR1_SB));				// wait until Flag UP (Start I2C)
	//SendTxt("...............START I2C\n");
}

void I2C_Send_Address(uint8_t Address, char direction){
	if (direction == 'w') {
			I2C2->DR		=(Address<<1)&0xFE;
			while( !(I2C2->SR1 &  I2C_SR1_ADDR));
			int status2=I2C2->SR2;
			//SendTxt("...............I2C SEND ADDRESS WRITE\n");
		}
		else if (direction == 'r') {
			I2C2->DR = ((Address<<1)|0x1);
			while(!(I2C2->SR1 & I2C_SR1_ADDR));			//wait until ADDR is received && read selected
			//SendTxt("...............I2C SEND ADDRESS READ\n");
		}

}

void I2C_Write (uint8_t data){
	I2C2->DR = data;
	while(!( I2C2->SR1 &I2C_SR1_TXE)); //wait until DR empty
	while(!(I2C2->SR1 & I2C_SR1_BTF));//wait until byteTrasferred
	//SendTxt("...............I2C WRITE\n");
}

void I2C_Stop(){
	I2C2->CR1 |= I2C_CR1_STOP;	// I2C STOP
	//SendTxt("...............I2C STOP\n\n");
}


void RTC_Read(uint8_t temps[]){
	I2C_Start();
	//SendTxt("trc start \n");
	I2C_Send_Address(RTC_ADDRESS,'w');
	//SendTxt("addr sent \n");
	I2C_Write(RTC_REGISTER);
	//SendTxt("reg sent \n");
	I2C_Start();
	I2C_Send_Address(RTC_ADDRESS,'r');
	//SendTxt("sent read \n");
	int i;
		for( i=0;i<=6;i++){
			if (i==6) {
				I2C2->CR1 &= ~ (I2C_CR1_ACK);	//not ackint status2=I2C2->SR2;
				int status2=I2C2->SR2;
				while(!(I2C2->SR1 & I2C_SR1_BTF));//wait until byteTrasferred

			}
			else {
				I2C2->CR1 |= I2C_CR1_ACK;	//ack
				int status2=I2C2->SR2;
				while(!(I2C2->SR1 & I2C_SR1_BTF));//wait until byteTrasferred
			}
			temps[i]=I2C2->DR;
		}
	I2C_Stop();
}


int main(void){
	uint8_t TEMPS[7];
    char Time[100]   ={0};


	Clock_Config();
	I2C_Config();
	USART_6();

	SendTxt("RTC using I2C:\n");
	while(1)
	{
		RTC_Read(TEMPS);
				if (TEMPS[2]< 0x10) sprintf(Time,"0%x",TEMPS[2]) ;
				else sprintf(Time,"%x",TEMPS[2]) ;
				SendTxt(Time);
				if (TEMPS[1]< 0x10) sprintf(Time,":0%x",TEMPS[1]) ;
				else sprintf(Time,":%x",TEMPS[1]) ;
				SendTxt(Time);
				if (TEMPS[0]< 0x10) sprintf(Time,":0%x",TEMPS[0]) ;
				else sprintf(Time,":%x ",TEMPS[0]) ;
				SendTxt(Time);
				switch (TEMPS[3]){
					case 1 : SendTxt("Monday    "); break;
					case 2 : SendTxt("Tuesday   "); break;
					case 3 : SendTxt("Wednesday "); break;
					case 4 : SendTxt("Thursday  "); break;
					case 5 : SendTxt("Friday    "); break;
					case 6 : SendTxt("Saturday  "); break;
					case 7 : SendTxt("Sunday    "); break;
				}
				if (TEMPS[4]< 0x10) sprintf(Time,":0%x",TEMPS[4]) ;
				else sprintf(Time," %x",TEMPS[4]) ;
				SendTxt(Time);
				if (TEMPS[5]< 0x10) sprintf(Time,":0%x",TEMPS[5]) ;
				else sprintf(Time,":%x",TEMPS[5]) ;
				SendTxt(Time);
				if (TEMPS[6]< 0x10) sprintf(Time,":200%x \n\n",TEMPS[6]) ;
				else sprintf(Time,":20%x \n\n",TEMPS[6]) ;
				SendTxt(Time);

	}
}

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
