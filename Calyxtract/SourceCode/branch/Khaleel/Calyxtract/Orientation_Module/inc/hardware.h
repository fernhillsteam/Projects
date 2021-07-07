/*
 * hardware.h
 *
 *  Created on: Jul 1, 2021
 *      Author: yallo
 */

#ifndef INC_HARDWARE_H_
#define INC_HARDWARE_H_

//Peripheral definitions

//Pneumatics
#define pneumatic           GPIO_PORTD_BASE //base
#define pod_accept_chute    GPIO_PIN_0
#define pod_reject_chute    GPIO_PIN_1
#define pod_tilter          GPIO_PIN_2
#define pod_chanelliser     GPIO_PIN_3

//Sensor
#define sensor              GPIO_PORTN_BASE
#define proximity_enter     GPIO_PIN_0
#define proximity_exit      GPIO_PIN_1

//Stepper motor
#define motor               GPIO_PORTH_BASE
#define stepper_dir         GPIO_PIN_0
#define stepper_pin         GPIO_PIN_1

//Encoder
#define encoder             GPIO_PORTL_BASE
#define enc_a               GPIO_PIN_1
#define enc_b               GPIO_PIN_2
#define enc_index           GPIO_PIN_3



//Configuration
#define gpio_init       1
#define uart_init       1
#define spi_init        1
#define i2c_init        1
#define dma_init        1
#define camera_init     1
#define can_init        1
#define flash_init      1

void hw_clk_config();
void hw_gpio_inout();
void hw_DMA_init(void);
void hw_I2C_init();
void hw_init();
void hw_dma_set_img(uint8_t *p_img);
uint8_t hw_is_dma_img_complete(void);
void wait_up();

#endif /* INC_HARDWARE_H_ */
