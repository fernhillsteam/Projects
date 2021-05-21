/*
 * memory.h
 *
 *  Created on: 07-May-2021
 *      Author: Sunil Pawar
 */

#ifndef INC_ADDRESS_MAPPING_H_
#define INC_ADDRESS_MAPPING_H_


#define block_size  65536
#define sector_size 4096
#define page_size   256

uint32_t page_index(uint32_t blk_num, uint32_t sec_num, uint32_t page_num);

void ControllerFunc();
void address_mapping();


#endif /* INC_ADDRESS_MAPPING_H_ */

