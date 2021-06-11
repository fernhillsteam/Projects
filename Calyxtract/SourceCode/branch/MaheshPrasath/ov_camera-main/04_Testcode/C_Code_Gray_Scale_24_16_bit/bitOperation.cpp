#if 0
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main()
{
	unsigned char red = 21;
	unsigned char green = 42;
	unsigned char blue = 20;
	unsigned temp;
	unsigned char firstByte; 
	unsigned char secondByte; 
	
	printf("Red Org value is %d  \n", red);
	red =  red << 3;
    printf("Red Shifted value is %d  \n", red);
    
    printf("green Org value is %d  ", green);
	temp =  green >> 3;
    printf("green Shifted value is %d  \n", temp);
    
    firstByte =  red | temp;
    
    printf("First byte value is %d  \n", firstByte);
    green = 42;
    temp = 0;
    temp =  green << 5;
    temp =  temp & 0xE0;
    printf("green second Shifted value is %d  \n", temp);
    blue = blue & 0x1F;
    secondByte = temp | blue;
    
    printf("Second byte value is %d  \n", secondByte);
	return 0;
}
#endif
