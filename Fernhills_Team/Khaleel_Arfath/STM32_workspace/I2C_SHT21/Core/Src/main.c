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



// Sensor Registers
#define SHT21_I2C_ADDRESS															0x40		// 1000 000
#define SHT21_I2C_ADDRESS_WRITE												0x80		// 1000 0000
#define SHT21_I2C_ADDRESS_READ												0x81		// 1000 0001

#define SHT21_TRIGGER_T_MEASUREMENT_HOLD_MASTER				0xE3		// 1110 0011
#define SHT21_TRIGGER_T_MEASUREMENT_NO_HOLD_MASTER		0xF3		// 1111 0011
#define SHT21_TRIGGER_RH_MEASUREMENT_HOLD_MASTER			0xE5		// 1110 0101
#define SHT21_TRIGGER_RH_MEASUREMENT_NO_HOLD_MASTER		0xF5		// 1111 0101
#define SHT21_WRITE_USER_REGISTER											0xE6		// 1110 0110
#define SHT21_READ_USER_REGISTER											0xE7		// 1110 0111
#define SHT21_SOFT_RESET															0xFE		// 1111 1110

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


uint8_t I2C2_ReadData(uint8_t slave_address, uint8_t device_register, uint16_t * data)
{
    uint8_t ack = 0;

		while (I2C2->SR2 & I2C_SR2_BUSY);				// Wait until bus not busy

		I2C_Start();									// Generate Start Condition

		I2C2->DR = (slave_address << 1);        // Write Slave Address + Write Bit
		while (!(I2C2->SR1 & I2C_SR1_ADDR));		// Wait until address flag is set
		ack = I2C2->SR2;                        // Get Acknowledge and clear address flag

		while (!(I2C2->SR1 & I2C_SR1_TXE));			// Wait until data register empty
		I2C2->DR = device_register;             // Write register address
		ack = I2C2->SR2;                        // Get Acknowledge and clear address flag

		while (!(I2C2->SR1 & I2C_SR1_TXE));			// Wait until data register empty
		while (!(I2C2->SR1 & I2C_SR1_BTF));			// Wait until byte transfer finished

	 // ==================================================================================

    I2C_Start();									// Generate Start Condition

		I2C2->DR = ((slave_address << 1) | 1);	// Write Slave Address + Read Bit

    while (!(I2C2->SR1 & I2C_SR1_ADDR));		// Wait until address flag is set
    I2C2->CR1 &= ~(I2C_CR1_ACK);						// Disable Acknowledge
    ack = I2C2->SR2;                        // Get Acknowledge and clear address flag

    while(!(I2C2->SR1 & I2C_SR1_RXNE));    	// Wait until RXNE flag is set

		// Normally
		//*data++ = I2C1->DR;                     // Read data from DR register

		// For SHT21
		*data++ = ((I2C2->DR) << 8);
    *data++ += I2C2->DR;

		I2C_Stop();										// Generate Stop Condition

    return ack;
}

float SHT21_GetTemperature(void)
{
	uint16_t temperature_raw_data = 0;
	float temperature_data = 0;

  I2C2_ReadData(SHT21_I2C_ADDRESS, SHT21_TRIGGER_T_MEASUREMENT_HOLD_MASTER, &temperature_raw_data);

	temperature_data = (-46.85 + 175.72 / 65536.0 * (float)(temperature_raw_data));

	return temperature_data;
}

// -----------------------------------------------------------------------------

float SHT21_GetHumidity(void)
{
	uint16_t humidity_raw_data = 0;
	float humidity_data = 0;

	I2C2_ReadData(SHT21_I2C_ADDRESS, SHT21_TRIGGER_RH_MEASUREMENT_HOLD_MASTER, &humidity_raw_data);

	humidity_data = (-6.0 + 125.0 / 65536.0 * (float)(humidity_raw_data));

	return humidity_data;
}

/* delay n milliseconds (16 MHz CPU clock) */
void delayMs(int n)
{
    int i;
    for (; n > 0; n--)
        for (i = 0; i < 3195; i++) ;
}

int main(void){
	Clock_Config();
	 I2C_Config();
	 USART_6();

	 uint8_t ekran[100] = {0};

	 	float temp = 0;
	 	float hum = 0;
	 	SendTxt("I2C SHt21...");

	 	while(1)
	 	{
	 		temp = SHT21_GetTemperature();
	 		hum = SHT21_GetHumidity();

	 		sprintf(ekran, "Sicaklik = %f\r\nNem = %f\r\n-----------------\r\n", temp, hum);

	 		SendTxt(ekran);

	 		delayMs(1000);
	 	}

	 	return 0;
}

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
