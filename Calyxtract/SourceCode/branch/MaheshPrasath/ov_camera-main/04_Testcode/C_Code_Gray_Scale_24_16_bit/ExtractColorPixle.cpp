#if 0
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main()
{
	unsigned char red;
	unsigned char greenH ;
	unsigned char greenL;
	unsigned char green;
	unsigned char blue;
	unsigned char firstByte = 0x24; 
	unsigned char secondByte = 0x49;; 
	
	red = firstByte >> 3;
	
	printf("Red Shifted value is %d  \n", red);
	
	greenH = firstByte & 0x07;
	greenL = secondByte & 0xE0;

	green = greenH | greenL;
	
	printf("green Shifted value is %d  \n", green);
	
	blue = secondByte & 0x1f;
	
	printf("blue Shifted value is %d  \n", blue);
}

#endif
