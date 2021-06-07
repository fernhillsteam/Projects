#if 1

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

//#define BMP_16
#define BMP_24

void extractToFile()
{

	int i;
#ifdef BMP_16
	FILE* f = fopen("4.bmp", "rb");
#endif

#ifdef BMP_24
	FILE* f = fopen("3.bmp", "rb");
#endif
 	
    FILE *fOut = fopen("grayoutput.bmp", "wb");	
	unsigned char header[54];
	fread(header, sizeof(unsigned char), 54, f); // read the 54-byte header
    fwrite(header, sizeof(unsigned char), 54, fOut);

	int width = *(int*)&header[18];
	int height = abs(*(int*)&header[22]);
	//int stride = (width * 3 + 3) & ~3;
	//int padding = stride - width * 3;

    printf("width: %d (%d)\n", width, width * 3);
    printf("height: %d\n", height);
    //printf("stride: %d\n", stride);
    //printf("padding: %d\n", padding);


//int width = 320, height = 240; // might want to extract that info from BMP header instead

int size_in_file = 2 * width * height;
unsigned char* data_from_file = new unsigned char[size_in_file];

fread(data_from_file, sizeof(unsigned char), size_in_file, f); // read the rest


fclose(f);

#ifdef BMP_24
	f = fopen("3.bmp", "rb");
#endif

#ifdef BMP_16
	f = fopen("4.bmp", "rb");
#endif


fread(header, sizeof(unsigned char), 54, f); // read the 54-byte header

unsigned char pixels[240 * 320][3];

#ifdef BMP_24
      unsigned char pixGrayScale[3];
#endif

#ifdef BMP_16
       unsigned char pixGrayScale[2];
#endif

unsigned char dummyPixRead[3];
unsigned int j = 0;
for(i = 0; i < width * height; ++i)
{
    fread(dummyPixRead, 3, 1, f);
#ifdef BMP_16
	unsigned char temp0 = data_from_file[i * 2 + 0];
    unsigned char temp1 = data_from_file[i * 2 + 1];

//	unsigned char temp0 = data_from_file[i + 0];
//    unsigned char temp1 = data_from_file[i + 1];
  
    unsigned short pixel_data = temp1 << 8 | temp0;

    // Extract red, green and blue components from the 16 bits
    pixels[i][0] = pixel_data >> 11;
    pixels[i][1] = (pixel_data >> 5) & 0x3f;
    pixels[i][2] = pixel_data & 0x1f;
    //unsigned char gray = (pixels[i][0] + pixels[i][1] + pixels[i][2] ) / 3;
   //unsigned char gray = pixels[i][0] * 0.212 + pixels[i][1] * 0.715 + pixels[i][2] * 0.072;
   //unsigned char gray = pixels[i][0] * 0.298 + pixels[i][1] * 0.587 + pixels[i][2] * 0.114;
    unsigned char gray = pixels[i][0] * 0.3 + pixels[i][1] * 0.58 + pixels[i][2] * 0.11;

#endif
/*	pixels[i][0] = dummyPixRead[0];
    pixels[i][1] = dummyPixRead[1];
    pixels[i][2] = dummyPixRead[2];
*/	
   
#ifdef BMP_24
    unsigned char gray = dummyPixRead[0] * 0.3 + dummyPixRead[1] * 0.58 + dummyPixRead[2] * 0.11;
#endif
   
#ifdef BMP_16
     unsigned char firstByte;
     unsigned char secondByte;
     unsigned char temp;
     unsigned char temp01;
     
     temp = gray << 3;
     temp01 = gray >> 3;
     
     temp = temp & 0xF1;
     temp01 = temp01 & 0x07;
     
     firstByte =  temp | temp01;
      
     temp = 0;
     temp =  gray << 5;
     temp =  temp & 0xE0; 
     temp01 = gray & 0x1F; 
     
     secondByte =  temp | temp01;
    
     unsigned short int temp3;
     temp3 = firstByte << 8;
     temp3 = temp3 & 0xFF00;
     temp3 = temp3 | secondByte;
     
     memset(pixGrayScale, temp3, sizeof(pixGrayScale));
     fwrite(&pixGrayScale, 2, 1, fOut);
#endif 
    
#ifdef BMP_24
	 memset(pixGrayScale, gray, sizeof(pixGrayScale));
     fwrite(&pixGrayScale, 3, 1, fOut);
#endif
/*	j++;
    if (j > (width -1 ))
    {
    	fread(dummyPixRead, padding, 1, f);
		fwrite(dummyPixRead, padding, 1, fOut);
    	j = 0;
	}
  */    
	/*pixGrayScale[i][0]  = gray;
    pixGrayScale[i][1] = gray;
    pixGrayScale[i][2]  = gray; */
    //memset(pixGrayScale[i], gray, sizeof(pixGrayScale));
}

fclose(fOut);
printf(" File extraction done");
/*
for(i = 0; i < width * height; ++i)
{
	printf("Red %d",pixGrayScale[i][0],'\t');
	printf(" Green %d",pixGrayScale[i][1],'\t');
	printf(" Blue %d",pixGrayScale[i][2],'\t');
	printf("\n");	
		
}
*/

}

int main()
{
	extractToFile();
	
	return 0;
}
#endif
