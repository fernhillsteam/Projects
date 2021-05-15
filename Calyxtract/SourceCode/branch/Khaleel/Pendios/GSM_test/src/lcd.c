#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_memmap.h"
#include "driverlib/debug.h"
#include "driverlib/gpio.h"
#include "driverlib/sysctl.h"
#include "inc/lcd.h"
#include "inc/dbg.h"

/* ============================ Defined constants ============================ */
//#define E  0x04                                             /* Enable on PE2 */
//#define RS 0x01                                             /* Read Select (RS) on PE0 */
//#define LCDDATA (*((volatile uint32_t *)0x400613FC))                            /* Parallel Data on PORTK (PK0 - PK7)  */
//#define LCDCMD (*((volatile uint32_t *)0x4005C0C0))                         /* Commands on PE5 and PE4 */

/* ============================ Function prototypes ============================ */
void OutCmd(unsigned char );
void LCD_OutChar(unsigned char );
void LCD_Clear(void);
void LCD_OutString(char *pt);
void LCD_OutUDec(uint32_t );
void PortFunctionInit(void);

/* ============================ LCD commands function ============================ */
void OutCmd(unsigned char command){
  //LCDDATA = command;
  //LCDDATA(command);
    command_mode();
    dbg_printf("\nlcd cmd=0x%x\n",command);
    GPIOPinWrite(GPIO_PORTK_BASE, GPIO_PIN_7|GPIO_PIN_6|GPIO_PIN_5|GPIO_PIN_4|GPIO_PIN_3|GPIO_PIN_2|GPIO_PIN_1|GPIO_PIN_0, command);

  //LCDCMD = 0;                                                   /* E=0, R/W=0, RS=0 */
  Dis();
  SysCtlDelay(240);                                         /* SysTick_Wait(T6us); wait 6us */
  //LCDCMD = E;                                               /* E=1, R/W=0, RS=0 */
  En();
  SysCtlDelay(240);                                         /* SysTick_Wait(T6us); wait 6us */
  //LCDCMD = 0;                                               /* E=0, R/W=0, RS=0 */
  Dis();
  SysCtlDelay(1600);                                            /* SysTick_Wait(T40us); wait 40us */
}

/* ============================ LCD Character function ============================ */
/* Output a character to the LCD, Inputs: letter is ASCII character, 0 to 0x7F, Outputs: none */
void LCD_OutChar(unsigned char letter){
  //LCDDATA = letter;
  //LCDDATA(letter);

  data_mode();
  dbg_printf("\nlcd data=0x%x\n",letter);
  GPIOPinWrite(GPIO_PORTK_BASE, GPIO_PIN_7|GPIO_PIN_6|GPIO_PIN_5|GPIO_PIN_4|GPIO_PIN_3|GPIO_PIN_2|GPIO_PIN_1|GPIO_PIN_0, letter);
  //  LCDCMD = RS;                                              /* E=0, R/W=0, RS=1 */
  Dis();
  SysCtlDelay(240);                                         /* SysTick_Wait(T6us); wait 6us */
  En();
  //LCDCMD = E+RS;                                            /* E=1, R/W=0, RS=1 */
  SysCtlDelay(240);                                         /* SysTick_Wait(T6us); wait 6us */
  //LCDCMD = RS;                                              /* E=0, R/W=0, RS=1 */
  Dis();
  SysCtlDelay(1600);                                            /* SysTick_Wait(T40us); wait 40us */
}

/*============================ Clear the LCD, Inputs: none, Outputs: none ============================ */
void LCD_Clear(void){
  OutCmd(0x01);                                             /* Clear Display */
  SysCtlDelay(64000);                                           /* SysTick_Wait(T1600us); wait 1.6ms */
  OutCmd(0x02);                                             /* Cursor to home */
  SysCtlDelay(64000);                                           /* SysTick_Wait(T1600us); wait 1.6ms */
}

/* ============================ LCD_OutString ============================  */
/* Output String (NULL termination), Input: pointer to a NULL-terminated string to be transferred, Output: none */
void LCD_OutString(char *pt){
  while(*pt){
    LCD_OutChar(*pt);
    pt++;
  }
}

/* ============================ LCD_OutUDec ============================ */
/* Output a 32-bit number in unsigned decimal format, Input: 32-bit number to be transferred, Output: none
   Variable format 1-10 digits with no space before or after */
void LCD_OutUDec(uint32_t n){
/*This function uses recursion to convert decimal number of unspecified length as an ASCII string */
  if(n >= 10){
    LCD_OutUDec(n/10);
    n = n%10;
  }
  LCD_OutChar(n+'0');                                           /* n is between 0 and 9 */
}

volatile uint32_t ui32SysClkFreq;

void Lcd_Init(void){

    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOE);  //Port E enable - enable and RS
    SysCtlPeripheralEnable(SYSCTL_PERIPH_GPIOK);  //Port K enable - enable data pins of lcd
        while(!SysCtlPeripheralReady(SYSCTL_PERIPH_GPIOE ))
        {
        }
        while(!SysCtlPeripheralReady(SYSCTL_PERIPH_GPIOK))
        {
        }

        GPIOPinTypeGPIOOutput(GPIO_PORTE_BASE, GPIO_PIN_0 | GPIO_PIN_2);
        GPIOPinTypeGPIOOutput(GPIO_PORTK_BASE, GPIO_PIN_0 | GPIO_PIN_1 | GPIO_PIN_2 | GPIO_PIN_3 | GPIO_PIN_4 | GPIO_PIN_5 | GPIO_PIN_6 | GPIO_PIN_7);

/* ============================ LCD controller initilization ============================ */
    //LCDCMD = 0;                                         /* E=0, R/W=0, RS=0 */
    command_mode();
    SysCtlDelay(600000);                                        /* Wait >15 ms after power is applied */
//    OutCmd(0x30);                                           /* command 0x30 = Wake up */
//    SysCtlDelay(200000);                                        /*must wait 5ms, busy flag not available */
//    OutCmd(0x30);                                           /* command 0x30 = Wake up #2 */
//    SysCtlDelay(6400);                                      /* must wait 160us, busy flag not available */
//    OutCmd(0x30);                                           /* command 0x30 = Wake up #3 */
//    SysCtlDelay(6400);                                      /* must wait 160us, busy flag not available */
    OutCmd(0x38);                                           /* Function set: 8-bit/2-line */
    OutCmd(0x10);                                           /* Set cursor */
    OutCmd(0x0C);                                           /* Display ON; Cursor ON */
    OutCmd(0x06);                                           /*auto increment*/
    OutCmd(0x01);
    OutCmd(0x02);
    dbg_printf("\nlcd initiated!!!");
}

//void LCDDATA1(unsigned char data)
//{
//    GPIOPinWrite(GPIO_PORTK_BASE, GPIO_PIN_7|GPIO_PIN_6|GPIO_PIN_5|GPIO_PIN_4|GPIO_PIN_3|GPIO_PIN_2|GPIO_PIN_1|GPIO_PIN_0, data);
//}

void data_mode()
{
    GPIOPinWrite(GPIO_PORTE_BASE ,  GPIO_PIN_0,GPIO_PIN_0);
}

void command_mode()
{
    GPIOPinWrite(GPIO_PORTE_BASE ,GPIO_PIN_0, 0x00);
}

void En()
{
    GPIOPinWrite(GPIO_PORTE_BASE ,  GPIO_PIN_2,GPIO_PIN_2);
}

void Dis()
{
    GPIOPinWrite(GPIO_PORTE_BASE ,GPIO_PIN_2, 0x00);
}
