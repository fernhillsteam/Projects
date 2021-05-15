#ifndef __LCD_H__
#define __LCD_H__

void OutCmd(unsigned char );
void LCD_OutChar(unsigned char );
void LCD_Clear(void);
void LCD_OutString(char *pt);
void LCD_OutUDec(uint32_t );
void  Lcd_Init(void);
void data_mode();
void command_mode();
void En();
void Dis();
#endif
