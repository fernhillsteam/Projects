#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <image.h>

#define MAXCHAR 10000
#define filePath "C:\\Users\\yallo\\Documents\\code_blocks\\rgb_gray\\rgb_gray\\bw.txt"

int main()
{

    uint8_t i=0;
    uint8_t *ptr = (uint8_t *)bmpdata;
    uint16_t pixel=0, red, green, blue, bw, grayscale;
    char temp[2];
    FILE *fPtr;

    fPtr = fopen(filePath, "a");
    if (fPtr == NULL)
        {
            /* Unable to open file hence exit */
            printf("\nUnable to open '%s' file.\n", filePath);
            printf("Please check whether file exists and you have write privilege.\n");
            exit(EXIT_FAILURE);
        }

for (i = 0; i < 320*240; i++)
    {

    pixel = (((uint8_t *)ptr)[1] << 8) | (((uint8_t *)ptr)[0] & 0xff);
    red = ((pixel & 0xF800)>>11);
    green = ((pixel & 0x07E0)>>6);
    blue = (pixel & 0x001F);
    grayscale = (red+green+blue)/3;
    bw =(grayscale<<11)+(grayscale<<6)+grayscale;
    temp[0]=(char)(bw & 0x00ff);
    temp[1]=(char)(bw & 0xff00);
    fputs(temp, fPtr);

    ptr += 2;
    }
    fclose(fPtr);
    printf("Session Completed");

    return 0;
}
