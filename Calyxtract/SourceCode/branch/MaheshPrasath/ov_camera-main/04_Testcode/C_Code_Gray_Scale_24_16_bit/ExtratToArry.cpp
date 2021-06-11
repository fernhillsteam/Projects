#if 0
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void extractToFile()
{

	int i;
	FILE* f = fopen("4.bmp", "rb");
    FILE *fOut = fopen("grayscale1.bmp", "wb");	
	unsigned char header[54];
	fread(header, sizeof(unsigned char), 54, f); // read the 54-byte header
    fwrite(header, sizeof(unsigned char), 54, fOut);

	int width = *(int*)&header[18];
	int height = abs(*(int*)&header[22]);
	int stride = (width * 3 + 3) & ~3;
	int padding = stride - width * 3;

    printf("width: %d (%d)\n", width, width * 3);
    printf("height: %d\n", height);
    printf("stride: %d\n", stride);
    printf("padding: %d\n", padding);


//int width = 320, height = 240; // might want to extract that info from BMP header instead

int size_in_file = 2 * width * height;
unsigned char* data_from_file = new unsigned char[size_in_file];

fread(data_from_file, sizeof(unsigned char), size_in_file, f); // read the rest


fclose(f);

f = fopen("4.bmp", "rb");
fread(header, sizeof(unsigned char), 54, f); // read the 54-byte header

unsigned char pixels[240 * 320][3];
unsigned char pixGrayScale[3];
unsigned char dummyPixRead[3];
unsigned int j = 0;
for(i = 0; i < width * height; ++i)
{
    fread(dummyPixRead, 3, 1, f);
	unsigned char temp0 = data_from_file[i * 2 + 0];
    unsigned char temp1 = data_from_file[i * 2 + 1];

//	unsigned char temp0 = data_from_file[i + 0];
//    unsigned char temp1 = data_from_file[i + 1];
  
    unsigned short pixel_data = temp1 << 8 | temp0;

    // Extract red, green and blue components from the 16 bits
    pixels[i][0] = pixel_data >> 11;
    pixels[i][1] = (pixel_data >> 5) & 0x3f;
    pixels[i][2] = pixel_data & 0x1f;
    
/*	pixels[i][0] = dummyPixRead[0];
    pixels[i][1] = dummyPixRead[1];
    pixels[i][2] = dummyPixRead[2];
*/	
	unsigned char gray = pixels[i][0] * 0.3 + pixels[i][1] * 0.58 + pixels[i][2] * 0.11;
 //   unsigned char gray = dummyPixRead[0] * 0.3 + dummyPixRead[1] * 0.58 + dummyPixRead[2] * 0.11;
    
	memset(pixGrayScale, gray, sizeof(pixGrayScale));
    fwrite(&pixGrayScale, 3, 1, fOut);
    
	/*j++;
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
