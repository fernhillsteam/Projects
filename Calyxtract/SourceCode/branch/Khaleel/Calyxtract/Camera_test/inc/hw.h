/*
 * hw.h
 *
 *  Created on: Jan 20, 2021
 *      Author: Admin
 */

#ifndef INC_HW_H_
#define INC_HW_H_

void dma_init(void);
void hw_dma_set_img(uint8_t *p_img);
uint8_t hw_is_dma_img_complete(void);


#endif /* INC_HW_H_ */
