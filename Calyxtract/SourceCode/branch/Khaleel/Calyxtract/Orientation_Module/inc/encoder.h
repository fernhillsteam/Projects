/*
 * encoder.h
 *
 *  Created on: Jul 7, 2021
 *      Author: yallo
 */

#ifndef INC_ENCODER_H_
#define INC_ENCODER_H_


volatile uint32_t qeiPosition;
volatile uint32_t qeiDirection;
volatile uint32_t qeiVelocity;


void Init_QEI0();

#endif /* INC_ENCODER_H_ */
