/**
 * ov7725.c
 *
 *  Created on: 19-09-2020
 *      Author: Khaleel Arfath J
 *
 * (c) Fernhills Technologies, 2020
 */

#include <stdint.h>
#include <stdbool.h>
#define TARGET_IS_TM4C129_RA1
#include "inc/hw_types.h"
#include "inc/hw_gpio.h"
#include "inc/hw_memmap.h"
#include "inc/hw_i2c.h"
#include "driverlib/i2c.h"
#include "driverlib/gpio.h"
#include "driverlib/udma.h"
#include "driverlib/sysctl.h"
//#include "inc/hw.h"
//#include "encoder.h"
#include "inc/sccb.h"
#include "inc/dbg.h"
#include "inc/ov7725.h"




#define I2C_BUSY_POLL_DELAY         (200000)
#define SKIP_FRAME_COUNT            (5)
#define ORIGINAL_DETECTION_LOGIC	(1)


static uint8_t *image;
static volatile bool busy = false;
static volatile bool read_frame = false;
static volatile uint16_t line_cnt = 0;
static volatile uint16_t frame_cnt = 0;
static volatile uint16_t frame_cnt1, frame_cnt2;
static uint16_t detected_line = 0;
static volatile uint_fast8_t skip_frame_cnt;

#if 0
#define QS                  0x44
//#define HSIZE               0x51
//#define VSIZE               0x52
#define XOFFL               0x53
#define YOFFL               0x54
#define VHYX                0x55
#define DPRP                0x56
#define TEST                0x57
#define ZMOW                0x5A
#define ZMOH                0x5B
#define ZMHH                0x5C
#define BPADDR              0x7C
#define BPDATA              0x7D
#define SIZEL               0x8C
#define HSIZE8              0xC0
#define VSIZE8              0xC1
#define CTRL1               0xC3
#define MS_SP               0xF0
#define SS_ID               0xF7
#define SS_CTRL             0xF7
#define MC_AL               0xFA
#define MC_AH               0xFB
#define MC_D                0xFC
#define P_CMD               0xFD
#define P_STATUS            0xFE

#define CTRLI               0x50
#define CTRLI_LP_DP         0x80
#define CTRLI_ROUND         0x40

#define CTRL0               0xC2
#define CTRL0_AEC_EN        0x80
#define CTRL0_AEC_SEL       0x40
#define CTRL0_STAT_SEL      0x20
#define CTRL0_VFIRST        0x10
#define CTRL0_YUV422        0x08
#define CTRL0_YUV_EN        0x04
#define CTRL0_RGB_EN        0x02
#define CTRL0_RAW_EN        0x01

#define CTRL2               0x86
#define CTRL2_DCW_EN        0x20
#define CTRL2_SDE_EN        0x10
#define CTRL2_UV_ADJ_EN     0x08
#define CTRL2_UV_AVG_EN     0x04
#define CTRL2_CMX_EN        0x01

#define CTRL3               0x87
#define CTRL3_BPC_EN        0x80
#define CTRL3_WPC_EN        0x40
#define R_DVP_SP            0xD3
#define R_DVP_SP_AUTO_MODE  0x80

#define R_BYPASS                0x05
#define R_BYPASS_DSP_EN         0x00
#define R_BYPASS_DSP_BYPAS      0x01

#define IMAGE_MODE              0xDA
#define IMAGE_MODE_Y8_DVP_EN    0x40
#define IMAGE_MODE_JPEG_EN      0x10
#define IMAGE_MODE_YUV422       0x00
#define IMAGE_MODE_RAW10        0x04
#define IMAGE_MODE_RGB565       0x08
#define IMAGE_MODE_HREF_VSYNC   0x02
#define IMAGE_MODE_LBYTE_FIRST  0x01

#define RESET                   0xE0
#define RESET_MICROC            0x40
#define RESET_SCCB              0x20
#define RESET_JPEG              0x10
#define RESET_DVP               0x04
#define RESET_IPU               0x02
#define RESET_CIF               0x01

#define MC_BIST                 0xF9
#define MC_BIST_RESET           0x80
#define MC_BIST_BOOT_ROM_SEL    0x40
#define MC_BIST_12KB_SEL        0x20
#define MC_BIST_12KB_MASK       0x30
#define MC_BIST_512KB_SEL       0x08
#define MC_BIST_512KB_MASK      0x0C
#define MC_BIST_BUSY_BIT_R      0x02
#define MC_BIST_MC_RES_ONE_SH_W 0x02
#define MC_BIST_LAUNCH          0x01

#define BANK_SEL                0xFF
#define BANK_SEL_DSP            0x00
#define BANK_SEL_SENSOR         0x01

/* Sensor register bank FF=0x01*/
#define GAIN                0x00
#define COM1                0x03
#define REG_PID             0x0A
#define REG_VER             0x0B
#define COM4                0x0D
#define AEC                 0x10
#define CLKRC               0x11
#define COM10               0x15
#define HSTART              0x17
#define HSTOP               0x18
#define VSTART              0x19
#define VSTOP               0x1A
#define MIDH                0x1C
#define MIDL                0x1D
#define AEW                 0x24
#define AEB                 0x25
#define REG2A               0x2A
#define FRARL               0x2B
#define ADDVSL              0x2D
#define ADDVSH              0x2E
#define YAVG                0x2F
#define HSDY                0x30
#define HEDY                0x31
#define ARCOM2              0x34
#define REG45               0x45
#define FLL                 0x46
#define FLH                 0x47
#define COM19               0x48
#define ZOOMS               0x49
#define COM22               0x4B
#define COM25               0x4E
#define BD50                0x4F
#define BD60                0x50
#define REG5D               0x5D
#define REG5E               0x5E
#define REG5F               0x5F
#define REG60               0x60
#define HISTO_LOW           0x61
#define HISTO_HIGH          0x62

#define REG04               0x04
#define REG04_DEFAULT       0x28
#define REG04_HFLIP_IMG     0x80
#define REG04_VFLIP_IMG     0x40
#define REG04_VREF_EN       0x10
#define REG04_HREF_EN       0x08
#define REG04_SET(x)        (REG04_DEFAULT|x)

#define REG08               0x08
#define COM2                0x09
#define COM2_STDBY          0x10
#define COM2_OUT_DRIVE_1x   0x00
#define COM2_OUT_DRIVE_2x   0x01
#define COM2_OUT_DRIVE_3x   0x02
#define COM2_OUT_DRIVE_4x   0x03

#define COM3                0x0C
#define COM3_DEFAULT        0x38
#define COM3_BAND_50Hz      0x04
#define COM3_BAND_60Hz      0x00
#define COM3_BAND_AUTO      0x02
#define COM3_BAND_SET(x)    (COM3_DEFAULT|x)

#define COM7                0x12
#define COM7_SRST           0x80
#define COM7_RES_UXGA       0x00 /* UXGA */
#define COM7_RES_SVGA       0x40 /* SVGA */
#define COM7_RES_CIF        0x20 /* CIF  */
#define COM7_ZOOM_EN        0x04 /* Enable Zoom */
#define COM7_COLOR_BAR      0x02 /* Enable Color Bar Test */

#define COM8                0x13
#define COM8_DEFAULT        0xC0
#define COM8_BNDF_EN        0x20 /* Enable Banding filter */
#define COM8_AGC_EN         0x04 /* AGC Auto/Manual control selection */
#define COM8_AEC_EN         0x01 /* Auto/Manual Exposure control */
#define COM8_SET(x)         (COM8_DEFAULT|x)

#define COM9                0x14 /* AGC gain ceiling */
#define COM9_DEFAULT        0x08
#define COM9_AGC_GAIN_2x    0x00 /* AGC:    2x */
#define COM9_AGC_GAIN_4x    0x01 /* AGC:    4x */
#define COM9_AGC_GAIN_8x    0x02 /* AGC:    8x */
#define COM9_AGC_GAIN_16x   0x03 /* AGC:   16x */
#define COM9_AGC_GAIN_32x   0x04 /* AGC:   32x */
#define COM9_AGC_GAIN_64x   0x05 /* AGC:   64x */
#define COM9_AGC_GAIN_128x  0x06 /* AGC:  128x */
#define COM9_AGC_SET(x)     (COM9_DEFAULT|(x<<5))

#define COM10               0x15
#define COM10_HREF_EN       0x80 /* HSYNC changes to HREF */
#define COM10_HSYNC_EN      0x40 /* HREF changes to HSYNC */
#define COM10_PCLK_FREE     0x20 /* PCLK output option: free running PCLK */
#define COM10_PCLK_EDGE     0x10 /* Data is updated at the rising edge of PCLK */
#define COM10_HREF_NEG      0x08 /* HREF negative */
#define COM10_VSYNC_NEG     0x02 /* VSYNC negative */
#define COM10_HSYNC_NEG     0x01 /* HSYNC negative */

#define CTRL1_AWB           0x08 /* Enable AWB */

#define VV                  0x26
#define VV_AGC_TH_SET(h,l)  ((h<<4)|(l&0x0F))

#define REG32               0x32
#define REG32_UXGA          0x36
#define REG32_SVGA          0x09
#define REG32_CIF           0x00

#endif

#if 0 == 0

static const uint8_t default_regs[][2] = {
    {COM3,          COM3_SWAP_YUV},
    {COM7,          COM7_RES_QVGA | COM7_FMT_YUV},

    {COM4,          0x01}, /* bypass PLL */
    {CLKRC,         0xC0}, /* Res/Bypass pre-scalar */

    // QVGA Window Size
    {HSTART,        0x3F},
    {HSIZE,         0x50},
    {VSTART,        0x03},
    {VSIZE,         0x78},
    {HREF,          0x00},

    // Scale down to QVGA Resolution
    {HOUTSIZE,      0x50},
    {VOUTSIZE,      0x78},

    {COM12,         0x03},
    {EXHCH,         0x00},
    {TGT_B,         0x7F},
    {FIXGAIN,       0x09},
    {AWB_CTRL0,     0xE0},
    {DSP_CTRL1,     0xFF},

    {DSP_CTRL2,     DSP_CTRL2_VDCW_EN | DSP_CTRL2_HDCW_EN | DSP_CTRL2_HZOOM_EN | DSP_CTRL2_VZOOM_EN},

    {DSP_CTRL3,     0x00},
    {DSP_CTRL4,     0x00},
    {DSPAUTO,       0xFF},

    {COM8,          0xF0},
    {COM6,          0xC5},
    {COM9,          0x11},
    {COM10,         COM10_VSYNC_NEG | COM10_PCLK_MASK}, //Invert VSYNC and MASK PCLK
    {BDBASE,        0x7F},
    {DBSTEP,        0x03},
    {AEW,           0x96},
    {AEB,           0x64},
    {VPT,           0xA1},
    {EXHCL,         0x00},
    {AWB_CTRL3,     0xAA},
    {COM8,          0xFF},

    //Gamma
    {GAM1,          0x0C},
    {GAM2,          0x16},
    {GAM3,          0x2A},
    {GAM4,          0x4E},
    {GAM5,          0x61},
    {GAM6,          0x6F},
    {GAM7,          0x7B},
    {GAM8,          0x86},
    {GAM9,          0x8E},
    {GAM10,         0x97},
    {GAM11,         0xA4},
    {GAM12,         0xAF},
    {GAM13,         0xC5},
    {GAM14,         0xD7},
    {GAM15,         0xE8},

    {SLOP,          0x20},
    {EDGE1,         0x05},
    {EDGE2,         0x03},
    {EDGE3,         0x00},
    {DNSOFF,        0x01},

    {MTX1,          0xB0},
    {MTX2,          0x9D},
    {MTX3,          0x13},
    {MTX4,          0x16},
    {MTX5,          0x7B},
    {MTX6,          0x91},
    {MTX_CTRL,      0x1E},

    {BRIGHTNESS,    0x08},
    {CONTRAST,      0x30},
    {UVADJ0,        0x81},
    {SDE,           (SDE_CONT_BRIGHT_EN | SDE_SATURATION_EN)},

    // For 30 fps/60Hz
    {DM_LNL,        0x00},
    {DM_LNH,        0x00},
    {BDBASE,        0x7F},
    {DBSTEP,        0x03},

    // Lens Correction, should be tuned with real camera module
    {LC_RADI,       0x10},
    {LC_COEF,       0x10},
    {LC_COEFB,      0x14},
    {LC_COEFR,      0x17},
    {LC_CTR,        0x05},
    {COM5,          0xF5}, //0x65

    {0xFF,          0xFF},
};

const uint8_t config[][2] =
{
  //{0x32,0x00}, // HREF, default = 00
  //{0x2a,0x00}, // EXHCH, default = 00
 {0x11,0x02}, // CLKRC, default = 80=75Hz, 0x01=50Hz, 0x02=30Hz,0x07=8Hz(3MHz), Tested 15fps (0x02)

  {0x12,0x46}, //QVGA RGB565, default = 00

  //{0x12,0x46},
  //{0x13,0xFF},//Default = 8F
  //{0x69,0x5D},

  //{0x0E,0xF5},

  {0x15,0x20},
#if 1
  {0x0C,0x10},
#else
  {0x0C,0x11},//test pattern
#endif
#if 0 == 1
  {0x42,0x7f}, // Blue Channel target gain, default = 80
  {0x4d,0x00},//0x09 // FixGain, default = 00
  {0x63,0xf0}, // AWB_Ctrl0, default = F0
  {0x64,0xff}, // DSP_Ctrl1, default = 1F
  {0x65,0x20}, // DSP_Ctrl2, default = 00
 {0x66,0x00}, // DSP_Ctrl3, default = 10
  {0x67,0x00}, // DSP_Ctrl4, default = 00
  {0x69,0x5d}, // AWB_Ctrl, default = 5C
#endif
#if 0 == 1
  {0x22,0xFF},//7f // BDBase, default = FF
  {0x23,0x01}, // BDMStep, default = 00
  {0x24,0x34}, // AEW, default = 76
  {0x25,0x3c}, // AEB, default = 63
  {0x26,0xa1}, // VPT, default = D4
  {0x2b,0x00}, // EXHCL, default = 00
  {0x6b,0xaa}, // AWBCtrl3, default = A2
#endif

#if 0 == 1
  {0x90,0x0a},// // EDGE1, default = 08
  {0x91,0x01},// // DNSOff, default = 10
  {0x92,0x01},// // EDGE2, default = 1F
  {0x93,0x01}, // EDGE3, default = 01
#endif

#if 0 == 1
  {0x94,0x5f}, // MTX1, default = 2C
  {0x95,0x53}, // MTX2, default = 24
  {0x96,0x11}, // MTX3, default = 08
  {0x97,0x1a}, // MTX4, default = 14
  {0x98,0x3d}, // MTX5, default = 24
  {0x99,0x5a}, // MTX6, default = 38
  {0x9a,0x1e}, // MTX_Ctrl, default = 9E
#endif
#if 0 == 0
    {0x9b,0x20},//set luma, default = 00
	//{0x9c,0x80},//25//set contrast, default = 40
	//{0xa7,0x80},//set saturation, default = 40
	//{0xa8,0x80},//set saturation, default = 40
	//{0xa9,0x80},//set hue, default = 80
	//{0xaa,0x80},//set hue, default = 80
#endif
#if 0 == 0
	//{0x9e,0x81}, // UVADJ0, default = 11
	{0xa6,0x06}, // SDE, default = 00
#endif
#if 0 == 1
	{0x7e,0x0c}, // GAM1, default = 0E
	{0x7f,0x16}, // GAM2, default = 1A
	{0x80,0x2a}, // GAM3, default = 31
	{0x81,0x4e}, // GAM4, default = 5A
	{0x82,0x61}, // GAM5, default = 69
	{0x83,0x6f}, // GAM6, default = 75
	{0x84,0x7b}, // GAM7, default = 7E
	{0x85,0x86}, // GAM8, default = 88
	{0x86,0x8e}, // GAM9, default = 8F
	{0x87,0x97}, // GAM10, default = 96
	{0x88,0xa4}, // GAM11, default = A3
	{0x89,0xaf}, // GAM12, default = AF
	{0x8a,0xc5}, // GAM13, default = C4
	{0x8b,0xd7}, // GAM14, default = D7
	{0x8c,0xe8}, // GAM15, default = E8
	{0x8d,0x20}, // SLOP, default = 20
#endif

#if 0 == 1
	{0x33,0x00}, // Dummy Rows, default = 00
	{0x22,0x99}, // BDBase, default = FF
	{0x23,0x03}, // BDMBase, dfeault = 01
	{0x4a,0x00}, // LC_RADI, default =30
	{0x49,0x13}, // LC_COEFF, default = 50
	{0x47,0x08}, // LC_YC, default = 00
	{0x4b,0x14}, // LC_COEFFB, default = 50
	{0x4c,0x17}, // LC_COEFFR, default = 50
	{0x46,0x05}, // LC_CTR, default = 00
#endif

#if 0

  {0x42,0x7f}, // Blue Channel target gain, default = 80
  {0x4d,0x00},//0x09 // FixGain, default = 00
  {0x63,0xf0}, // AWB_Ctrl0, default = F0
  {0x64,0xff}, // DSP_Ctrl1, default = 1F
  {0x65,0x20}, // DSP_Ctrl2, default = 00
  {0x66,0x00}, // DSP_Ctrl3, default = 10
  {0x67,0x00}, // DSP_Ctrl4, default = 00
  {0x69,0x5d}, // AWB_Ctrl, default = 5C


  {0x13,0xff}, // COM8, default = 8F
/*  {0x0d,0x61},//PLL*/
  {0x0f,0xc5}, // COM6, default = 43
  {0x14,0x11}, // COM9, default = 4A
  {0x22,0xFF},//7f // BDBase, default = FF
  {0x23,0x01}, // BDMStep, default = 00
  {0x24,0x34}, // AEW, default = 76
  {0x25,0x3c}, // AEB, default = 63
  {0x26,0xa1}, // VPT, default = D4
  {0x2b,0x00}, // EXHCL, default = 00
  {0x6b,0xaa}, // AWBCtrl3, default = A2
  {0x13,0xff}, // COM8, default = 8F

  {0x90,0x0a},// // EDGE1, default = 08
  {0x91,0x01},// // DNSOff, default = 10
  {0x92,0x01},// // EDGE2, default = 1F
  {0x93,0x01}, // EDGE3, default = 01

  {0x94,0x5f}, // MTX1, default = 2C
  {0x95,0x53}, // MTX2, default = 24
  {0x96,0x11}, // MTX3, default = 08
  {0x97,0x1a}, // MTX4, default = 14
  {0x98,0x3d}, // MTX5, default = 24
  {0x99,0x5a}, // MTX6, default = 38
  {0x9a,0x1e}, // MTX_Ctrl, default = 9E

  {0x9b,0x00},//set luma, default = 00
  {0x9c,0x25},//set contrast, default = 40
  {0xa7,0x65},//set saturation, default = 40
  {0xa8,0x65},//set saturation, default = 40
  {0xa9,0x80},//set hue, default = 80
  {0xaa,0x80},//set hue, default = 80

  {0x9e,0x81}, // UVADJ0, default = 11
  {0xa6,0x06}, // SDE, default = 00

  {0x7e,0x0c}, // GAM1, default = 0E
  {0x7f,0x16}, // GAM2, default = 1A
  {0x80,0x2a}, // GAM3, default = 31
  {0x81,0x4e}, // GAM4, default = 5A
  {0x82,0x61}, // GAM5, default = 69
  {0x83,0x6f}, // GAM6, default = 75
  {0x84,0x7b}, // GAM7, default = 7E
  {0x85,0x86}, // GAM8, default = 88
  {0x86,0x8e}, // GAM9, default = 8F
  {0x87,0x97}, // GAM10, default = 96
  {0x88,0xa4}, // GAM11, default = A3
  {0x89,0xaf}, // GAM12, default = AF
  {0x8a,0xc5}, // GAM13, default = C4
  {0x8b,0xd7}, // GAM14, default = D7
  {0x8c,0xe8}, // GAM15, default = E8
  {0x8d,0x20}, // SLOP, default = 20

  {0x33,0x00}, // Dummy Rows, default = 00
  {0x22,0x99}, // BDBase, default = FF
  {0x23,0x03}, // BDMBase, dfeault = 01
  {0x4a,0x00}, // LC_RADI, default =30
  {0x49,0x13}, // LC_COEFF, default = 50
  {0x47,0x08}, // LC_YC, default = 00
  {0x4b,0x14}, // LC_COEFFB, default = 50
  {0x4c,0x17}, // LC_COEFFR, default = 50
  {0x46,0x05}, // LC_CTR, default = 00
  {0x0e,0xf5}, // COM5, default = 01
  {0x0c,0xd0}, // COM3, default = 10

#endif
  {0x08,0x01},  // LB, exposure gain
  {0x09,0x03},  // COM2, Default = 01
  {0x10,0x05},  // HB, exposure gain
  {0x13,0x00},  // COM8, Default = CF to disable AGC, AWB and AEC
  {0x63,0xF0},  // AWB gain disable, default = 70 in data-sheet but FF should be used
  {0x64,0xb8},
  {0x69,0x54},
  {0x00,0x05},
  {0x01,0x40},
  {0x02,0x40},
  {0x03,0x20},
  {0xff,0xff}
  };

#else
const uint8_t config[][2] =
{
// {0x32,0x00},
//   {0x2a,0x00},
//   {0x11,0x02},
//   {0x12,0x46},//QVGA RGB565
//  // {0x12,0x06},
//
//
//   {0x42,0x7f},
//   {0x4d,0x00},//0x09
//   {0x63,0xf0},
//   {0x64,0xff},
//   {0x65,0x20},
//   {0x66,0x00},
//   {0x67,0x00},
//   {0x69,0x5d},
//
//
//   {0x13,0xff},
//   {0x0d,0x81},//PLL
//   {0x0f,0xc5},
//   {0x14,0x11},
//   {0x22,0xFF},//7f
//   {0x23,0x01},
//   {0x24,0x34},
//   {0x25,0x3c},
//   {0x26,0xa1},
//   {0x2b,0x00},
//   {0x6b,0xaa},
//   {0x13,0xff},
//
//   {0x90,0x0a},//
//   {0x91,0x01},//
//   {0x92,0x01},//
//   {0x93,0x01},
//
//   {0x94,0x5f},
//   {0x95,0x53},
//   {0x96,0x11},
//   {0x97,0x1a},
//   {0x98,0x3d},
//   {0x99,0x5a},
//   {0x9a,0x1e},
//
//   {0x9b,0x00},//set luma
//   {0x9c,0x25},//set contrast
//   {0xa7,0x65},//set saturation
//   {0xa8,0x65},//set saturation
//   {0xa9,0x80},//set hue
//   {0xaa,0x80},//set hue
//
//   {0x9e,0x81},
//   {0xa6,0x06},
//
//   {0x7e,0x0c},
//   {0x7f,0x16},
//   {0x80,0x2a},
//   {0x81,0x4e},
//   {0x82,0x61},
//   {0x83,0x6f},
//   {0x84,0x7b},
//   {0x85,0x86},
//   {0x86,0x8e},
//   {0x87,0x97},
//   {0x88,0xa4},
//   {0x89,0xaf},
//   {0x8a,0xc5},
//   {0x8b,0xd7},
//   {0x8c,0xe8},
//   {0x8d,0x20},
//
//   {0x33,0x00},
//   {0x22,0x99},
//   {0x23,0x03},
//   {0x4a,0x00},
//   {0x49,0x13},
//   {0x47,0x08},
//   {0x4b,0x14},
//   {0x4c,0x17},
//   {0x46,0x05},
//   {0x0e,0x75},
//   {0x0c,0x90},
//   {0x00,0xf0},
//   {0x29,0x50},
//   {0x2C,0x78},
 //google settings
// {0x2a,0x00}, //QVGA : {0x2a,0x00} , QQVGA : {0x2a,0x00}
//     {0x11,0x02}, // 00/01/03/07 for 60/30/15/7.5fps  - set to 15fps for QVGA
//     //{0x0D,0xF1},
//     {0x12,0x46}, /* QVGA RGB565 {0x12,0x46}, QQVGA RGB565 {0x12,0x46}*/
//     {0x17,0x3F},
//     {0x18,0x50},
//     {0x19,0x03},
//     {0x1A,0x78},
//     {0x32,0x80},
//
//     {0xAC,0xff}, //auto scaling
//     {0x42,0x7f},
//     {0x4d,0x00}, /* 0x09 */
//     {0x63,0xf0},
//     {0x64,0xff},
//     {0x65,0x00}, //0x20
//     {0x66,0x10}, //0x00
//     {0x67,0x00},
//     {0x69,0x5C},
//     {0x13,0x8F},  //{0x13,0xff},
//     {0x0d,0x41}, /* PLL, 0xc1*/
//     {0x0f,0x43}, //0xc5
//     {0x14,0x4A}, //{0x14,0x11},
//     {0x22,0x3F}, // ff/7f/3f/1f for 60/30/15/7.5fps
//     {0x23,0x07}, // 01/03/07/0f for 60/30/15/7.5fps
//     {0x24,0x34},
//     {0x25,0x3c},
//     {0x26,0xa1},
//     {0x2b,0x00},
//     {0x6b,0xaa},
//
//     {0x90,0x0a},
//     {0x91,0x01}, //{0x91,0x01}
//     {0x92,0x01}, //{0x92,0x01}
//     {0x93,0x01},
//
//     {0x94,0x5f}, //{0x94,0x5f}
//     {0x95,0x53}, //{0x95,0x53}
//     {0x96,0x11}, //{0x96,0x11}
//     {0x97,0x1a}, //{0x97,0x1a}
//     {0x98,0x3d}, //{0x98,0x3d}
//     {0x99,0x5a}, //{0x99,0x5a}
//     {0x9a,0x1e}, //{0x9a,0x1e}
//
//     {0x9b,0x00}, /* set luma */
//     {0x9c,0x25}, /* set contrast */
//     {0xa7,0x40}, /* set saturation {0xa7,0x65}*/
//     {0xa8,0x40}, /* set saturation {0xa8,0x65}*/
//     {0xa9,0x80}, /* set hue */
//     {0xaa,0x80}, /* set hue */
//
//     {0x9e,0x81},
//     {0xa6,0x00},
//     {0x7e,0x0c},
//     {0x7f,0x16},
//     {0x80,0x2a},
//     {0x81,0x4e},
//     {0x82,0x61},
//     {0x83,0x6f},
//     {0x84,0x7b},
//     {0x85,0x86},
//     {0x86,0x8e},
//     {0x87,0x97},
//     {0x88,0xa4},
//     {0x89,0xaf},
//     {0x8a,0xc5},
//     {0x8b,0xd7},
//     {0x8c,0xe8},
//     {0x8d,0x20},
//     {0x33,0x00},
//     {0x22,0x99},
//     {0x23,0x03},
//     {0x4a,0x00},
//     {0x49,0x50}, //{0x49,0x13}
//     {0x47,0x08}, //{0x47,0x08}
//     {0x4b,0x14}, //{0x4b,0x14}
//     {0x4c,0x17}, //{0x4c,0x17}
//     {0x46,0x00}, //{0x46,0x05}
//     {0x0e,0x01}, //{0x0e,0xf5}1111,0101
//     {0x0c,0xC0}, //bit6 : Horizontal Mirror, bit0 : test pattern enable
//
//     {0x29,0x50},    //_USE_QVGA
//     {0x2c,0x78},    //_USE_QVGA

 //new settings
 {0x11,0x02}, // CLKRC, default = 80=75Hz, 0x01=50Hz, 0x02=30Hz,0x07=8Hz(3MHz), Tested 15fps (0x02)

  {0x12,0x46}, //QVGA RGB565, default = 00
  {0x0C,0x10},
  {0x15,0x20},

 {0x3d, 0x03},
 {0x42, 0x7f},
 {0x4d, 0x09},

// DSP //
 {0x64, 0xff},
 {0x65, 0x20},
 {0x66, 0x00},
 {0x67, 0x48},
 {0x0f, 0xc5},
 {0x13, 0xff},

// AEC/AGC/AWB //
 {0x63, 0xe0},
 {0x14, 0x11},
 {0x22, 0x3f},
 {0x23, 0x07},
 {0x24, 0x40},
 {0x25, 0x30},
 {0x26, 0xa1},
 {0x2b, 0x00},
 {0x6b, 0xaa},
 {0x0d, 0x41},

// Sharpness. //
 {0x90, 0x05},
 {0x91, 0x01},
 {0x92, 0x03},
 {0x93, 0x00},

 // Matrix. //
 {0x94, 0x90},
 {0x95, 0x8a},
 {0x96, 0x06},
 {0x97, 0x0b},
 {0x98, 0x95},
 {0x99, 0xa0},
 {0x9a, 0x1e},

 // Brightness. //
 {0x9b, 0x08},
 // Contrast. //
 {0x9c, 0x20},
// UV //
 {0x9e, 0x81},
// DSE //
 {0xa6, 0x04},

// Gamma. //
 {0x7e, 0x0c},
 {0x7f, 0x16},
 {0x80, 0x2a},
 {0x81, 0x4e},
 {0x82, 0x61},
 {0x83, 0x6f},
 {0x84, 0x7b},
 {0x85, 0x86},
 {0x86, 0x8e},
 {0x87, 0x97},
 {0x88, 0xa4},
 {0x89, 0xaf},
 {0x8a, 0xc5},
 {0x8b, 0xd7},
 {0x8c, 0xe8},
//
 {CLKRC,     0x00}, //clock config
     {COM7,      0x46}, //QVGA RGB565
//     {HSTART,    0x3f}, //
//     {HSIZE,     0x50}, //
//     {VSTRT,     0x03}, //
//     {VSIZE,     0x78}, //
//     {HREF,      0x00},
//     {HOutSize,  0x50}, //
//     {VOutSize,  0x78}, //
     {0x0c,0x10},

     //DSP control//
     {TGT_B,     0x7f},
     {FixGain,   0x09},
     {AWB_Ctrl0, 0xe0},
     {DSP_Ctrl1, 0xff},
     {DSP_Ctrl2, 0x00},
     {DSP_Ctrl3, 0x00},
     {DSP_Ctrl4, 0x00},

     //AGC AEC AWB//
     {COM8,      0xf0},
     {COM4,      0x81}, //Pll AEC CONFIG//
     {COM6,      0xc5},
     {COM9,      0x11},
     {BDBase,    0x7F},
     {BDMStep,   0x03},
     {AEW,       0x40},
     {AEB,       0x30},
     {VPT,       0xa1},
     {EXHCL,     0x9e},
     {AWBCtrl3,  0xaa},
     {COM8,      0xff},

     //matrix shapness brightness contrast//
     {EDGE1,     0x08},
     {DNSOff,    0x01},
     {EDGE2,     0x03},
     {EDGE3,     0x00},
     {MTX1,      0xb0},
     {MTX2,      0x9d},
     {MTX3,      0x13},
     {MTX4,      0x16},
     {MTX5,      0x7b},
     {MTX6,      0x91},
     {MTX_Ctrl,  0x1e},
     {BRIGHT,    0x08},
     {CNST,      0x20},
     {UVADJ0,    0x81},
     {SDE,       0X06},
     {USAT,      0x65},
     {VSAT,      0x65},
     {HUECOS,    0X80},
     {HUESIN,    0X80},

     //GAMMA config//
     {GAM1,      0x0c},
     {GAM2,      0x16},
     {GAM3,      0x2a},
     {GAM4,      0x4e},
     {GAM5,      0x61},
     {GAM6,      0x6f},
     {GAM7,      0x7b},
     {GAM8,      0x86},
     {GAM9,      0x8e},
     {GAM10,     0x97},
     {GAM11,     0xa4},
     {GAM12,     0xaf},
     {GAM13,     0xc5},
     {GAM14,     0xd7},
     {GAM15,     0xe8},
     {SLOP,      0x20},


     {COM3,      0x10},


     {COM5,      0xf5},
     //{COM5,        0x31},
      {0xff,0xff}
};

#endif
//static const uint16_t pixel_to_enc_count[240] =
//{
//	 0,   1,   2,   4,   5,   6,   8,   9,  10,  11,  12,  14,  15,  16,  18,  19,
//	20,  21,  22,  24,  25,  26,  28,  29,  30,  31,  32,  34,  35,  36,  38,  39,
//	40,  41,  42,  44,  45,  46,  48,  49,  50,  51,  52,  54,  55,  56,  58,  59,
//	60,  61,  62,  64,  65,  66,  68,  69,  70,  71,  72,  74,  75,  76,  78,  79,
//	80,  81,  82,  84,  85,  86,  88,  89,  90,  91,  92,  94,  95,  96,  98,  99,
//	100, 101, 102, 104, 105, 106, 108, 109, 110, 111, 112, 114, 115, 116, 118, 119,
//	120, 121, 122, 124, 125, 126, 128, 129, 130, 131, 132, 134, 135, 136, 138, 139,
//	140, 141, 142, 144, 145, 146, 148, 149, 150, 151, 152, 154, 155, 156, 158, 159,
//	160, 161, 162, 164, 165, 166, 168, 169, 170, 171, 172, 174, 175, 176, 178, 179,
//	180, 181, 182, 184, 185, 186, 188, 189, 190, 191, 192, 194, 195, 196, 198, 199,
//	200, 201, 202, 204, 205, 206, 208, 209, 210, 211, 212, 214, 215, 216, 218, 219,
//	220, 221, 222, 224, 225, 226, 228, 229, 230, 231, 232, 234, 235, 236, 238, 239,
//	240, 241, 242, 244, 245, 246, 248, 249, 250, 251, 252, 254, 255, 256, 258, 259,
//	260, 261, 262, 264, 265, 266, 268, 269, 270, 271, 272, 274, 275, 276, 278, 279,
//	280, 281, 282, 284, 285, 286, 288, 289, 290, 291, 292, 294, 295, 296, 298, 299,
//};

void ov7725_reset(bool en)
{
	if (en)
		GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_0, 0);
	else
		GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_0, GPIO_PIN_0);
}

void ov7725_pwr_dn(bool en)
{
	if (en)
		GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_1, GPIO_PIN_1);
	else
		GPIOPinWrite(GPIO_PORTG_BASE, GPIO_PIN_1, 0);
}

#define COM3_SET_SWAPBR(r, x)   ((r&0xDF)|((x&1)<<5))
#define COM3_SET_CBAR(r, x)     ((r&0xFE)|((x&1)<<0))
#define COM3_SET_MIRROR(r, x)   ((r&0xBF)|((x&1)<<6))
#define COM3_SET_FLIP(r, x)     ((r&0x7F)|((x&1)<<7))
#define DSP_CTRL3_SET_CBAR(r, x)    ((r&0xDF)|((x&1)<<5))
#define COM7_SET_FMT(r, x)      ((r&0xFC)|((x&0x3)<<0))
#define COM8_SET_AGC(r, x)      ((r&0xFB)|((x&0x1)<<2))
#define COM8_SET_AWB(r, x)      ((r&0xFD)|((x&0x1)<<1))
#define COM8_SET_AEC(r, x)      ((r&0xFE)|((x&0x1)<<0))

static void set_pixformat()
{
    //int ret=0;
    // Read register COM7
    uint8_t reg = SCCB0_Read_Reg(COM7);

    //case PIXFORMAT_RGB565:
        reg =  COM7_SET_FMT(reg, COM7_FMT_RGB) | COM7_FMT_RGB565;

    //case PIXFORMAT_YUV422:
    //case PIXFORMAT_GRAYSCALE:
        //reg =  COM7_SET_FMT(reg, COM7_FMT_YUV);
    SCCB0_Write_Reg(COM7, reg);
    SysCtlDelay(5000);
}

static void set_framesize()
{
    uint16_t w = 320;
    uint16_t h = 240;

    // Write MSBs
    SCCB0_Write_Reg(HOUTSIZE, w>>2);
    SCCB0_Write_Reg(VOUTSIZE, h>>1);

    // Write LSBs
    SCCB0_Write_Reg(EXHCH, ((w&0x3) | ((h&0x1) << 2)));

    // Enable auto-scaling/zooming factors
    SCCB0_Write_Reg(DSPAUTO, 0xFF);

    SysCtlDelay(5000);
}


static void set_colorbar()
{
    int ret=0;
    uint8_t reg;

    // Read reg COM3
    reg = SCCB0_Read_Reg(COM3);
    // Enable colorbar test pattern output
    reg = COM3_SET_CBAR(reg, 1);
    // Write back COM3
    ret |= SCCB0_Write_Reg(COM3, reg);

    // Read reg DSP_CTRL3
    reg = SCCB0_Read_Reg(DSP_CTRL3);
    // Enable DSP colorbar output
    reg = DSP_CTRL3_SET_CBAR(reg, 1);
    // Write back DSP_CTRL3
    SCCB0_Write_Reg(DSP_CTRL3, reg);
}

static void set_whitebal(int enable)
{
    // Read register COM8
    uint8_t reg = SCCB0_Read_Reg(COM8);

    // Set white bal on/off
    reg = COM8_SET_AWB(reg, enable);

    // Write back register COM8
    SCCB0_Write_Reg(COM8, 0xFF);
}

static void set_gain_ctrl(int enable)
{
    // Read register COM8
    uint8_t reg = SCCB0_Read_Reg(COM8);

    // Set white bal on/off
    reg = COM8_SET_AGC(reg, enable);

    // Write back register COM8
    SCCB0_Write_Reg(COM8, reg);
}

static void set_exposure_ctrl(int enable)
{
    // Read register COM8
    uint8_t reg = SCCB0_Read_Reg(COM8);

    // Set white bal on/off
    reg = COM8_SET_AEC(reg, enable);

    // Write back register COM8
    SCCB0_Write_Reg(COM8, reg);
}
static void set_hmirror(int enable)
{
    // Read register COM3
    uint8_t reg = SCCB0_Read_Reg(COM3);

    // Set mirror on/off
    reg = COM3_SET_MIRROR(reg, enable);

    // Write back register COM3
    SCCB0_Write_Reg(COM3, reg);
}

static void set_swapbr(int enable)
{
    // Read register COM3
    uint8_t reg = SCCB0_Read_Reg(COM3);

    // Set mirror on/off
    reg = COM3_SET_SWAPBR(reg, enable);

    // Write back register COM3
    SCCB0_Write_Reg(COM3, reg);
}

static void set_vflip(int enable)
{
    // Read register COM3
    uint8_t reg = SCCB0_Read_Reg(COM3);

    // Set mirror on/off
    reg = COM3_SET_FLIP(reg, enable);

    // Write back register COM3
    SCCB0_Write_Reg(COM3, reg);
}

void cam_ov7725_init(void)
{
	ov7725_pwr_dn(true);
	ov7725_reset(true);

	SysCtlDelay(500000*200);

	ov7725_pwr_dn(false);
	ov7725_reset(false);

	SysCtlDelay(500000*200);

	SCCB0_Write_Reg(COM7, COM7_RESET);

	//dbg_printf("OV7725: Camera reset complete.\r\n");
	SysCtlDelay(500000*200);

	int i = 0;
	uint8_t tmp;

	//dbg_printf("OV7725: Initializing ...\r\n");
	uint8_t (*regPtr)[2] = (uint8_t (*)[2])config;
    //uint8_t (*regPtr)[2] = (uint8_t (*)[2])default_regs;
    while (regPtr[i][0] != 0xFF)
	{
		//hw_delay(I2C_DELAY_BIT_BANG*10);
		tmp = SCCB0_Write_Reg(regPtr[i][0], regPtr[i][1]);//ov7725_write_reg(regPtr[i][0], regPtr[i][1]);
		//dbg_printf("OV7725: I2C write done : %02X  %02X.\r\n",regPtr[i][0], regPtr[i][1]);
		SysCtlDelay(5000);
		tmp = SCCB0_Read_Reg(regPtr[i][0]);
		//dbg_printf("%02X=%02X\r\n", regPtr[i][0], tmp);
		if (tmp == regPtr[i][1])
			++i;
	}
	//dbg_printf("OV7725: Init done.\r\n");
    set_pixformat();
    set_framesize();
    set_pixformat();
#if 0
    //set_swapbr(1);
    set_colorbar();// Color pattern
#endif
    set_whitebal(1);
    set_gain_ctrl(1);
    set_exposure_ctrl(1);
    set_hmirror(1);
    set_vflip(1);
}

uint16_t
OV77255CheckPIDVER(void)
{
    uint8_t  ui8PIDValue = 0;
    uint8_t  ui8VERValue = 0;
    uint16_t ui16DeviceInfo = 0;
    dbg_printf("OV7725PIDVER\r\n");

    SCCB0_Write_Reg(0x12, 0x80);
    //dbg_printf("OV7725: Camera reset complete.\r\n");
    SysCtlDelay(500000*200);

    ui8PIDValue = SCCB0_Read_ID(0x0A);
    SysCtlDelay(5000);
    ui8VERValue = SCCB0_Read_ID(0x0B);
    SysCtlDelay(5000);
    dbg_printf("%x\r\n",ui8PIDValue);
    dbg_printf("%x\r\n",ui8VERValue);
    //ui16DeviceInfo = (ui8PIDValue << 8) | ui8VERValue;

    return(ui16DeviceInfo);
}

/*
uint8_t ov7725_read_reg(uint8_t reg)
{
	uint32_t err;

	SysCtlDelay(4000000);

	while(I2CMasterBusy(I2C5_BASE))
		;

	I2CMasterSlaveAddrSet(I2C5_BASE, 0x21, false);

	I2CMasterDataPut(I2C5_BASE, reg);

	I2CMasterControl(I2C5_BASE, I2C_MASTER_CMD_SINGLE_SEND);

	//SysCtlDelay(I2C_BUSY_POLL_DELAY);
	while(!I2CMasterBusy(I2C5_BASE))
		;

	while(I2CMasterBusy(I2C5_BASE))
		;

	err = I2CMasterErr(I2C5_BASE);

	if (err)
	{
		dbg_printf("Err = %08X\r\n", err);
		return 0;
	}

	I2CMasterSlaveAddrSet(I2C5_BASE, 0x21, true);

	I2CMasterControl(I2C5_BASE, I2C_MASTER_CMD_SINGLE_RECEIVE);

	//SysCtlDelay(I2C_BUSY_POLL_DELAY);
	while(!I2CMasterBusy(I2C5_BASE))
		;

	while(I2CMasterBusy(I2C5_BASE))
		;

	err = I2CMasterErr(I2C5_BASE);

	if (err)
	{
		dbg_printf("Err = %08X\r\n", err);
		return 0;
	}

	return I2CMasterDataGet(I2C5_BASE);
}

uint8_t ov7725_write_reg(uint8_t reg, uint8_t value)
{
	uint32_t err;

	SysCtlDelay(4000000);

	while(I2CMasterBusy(I2C5_BASE))
		;

	I2CMasterSlaveAddrSet(I2C5_BASE, 0x21, false);

	I2CMasterDataPut(I2C5_BASE, reg);

	I2CMasterControl(I2C5_BASE, I2C_MASTER_CMD_BURST_SEND_START);

	//SysCtlDelay(I2C_BUSY_POLL_DELAY);
	while(!I2CMasterBusy(I2C5_BASE))
		;

	while(I2CMasterBusy(I2C5_BASE))
		;

	err = I2CMasterErr(I2C5_BASE);

	if (err)
	{
		dbg_printf("Err = %08X\r\n", err);
		return 0;
	}

	I2CMasterDataPut(I2C5_BASE, value);

	I2CMasterControl(I2C5_BASE, I2C_MASTER_CMD_BURST_SEND_CONT);

	//SysCtlDelay(I2C_BUSY_POLL_DELAY);
	while(!I2CMasterBusy(I2C5_BASE))
		;

	while(I2CMasterBusy(I2C5_BASE))
		;

	err = I2CMasterErr(I2C5_BASE);

	if (err)
	{
		dbg_printf("Err = %08X\r\n", err);
		return 0;
	}

	I2CMasterControl(I2C5_BASE, I2C_MASTER_CMD_BURST_SEND_FINISH);

	//SysCtlDelay(I2C_BUSY_POLL_DELAY);
	while(!I2CMasterBusy(I2C5_BASE))
		;

	while(I2CMasterBusy(I2C5_BASE))
		;

	err = I2CMasterErr(I2C5_BASE);

	if (err)
	{
		dbg_printf("Err = %08X\r\n", err);
		return 0;
	}

	return err;
}*/

bool ov7725_setup_frame_buf(uint8_t *img)
{
	if (read_frame || busy)
		return false;

	image = img;
	busy = true;

	return true;
}

bool ov7725_is_image_acquired(void)
{
	return (read_frame || busy);
}

bool ov7725_detect(void)
{
	uint16_t processed_line = 0;
	uint16_t cnt;
	uint16_t tmp;
	uint8_t r, g, b;
	uint16_t white_count;
	uint16_t row_count = 0;
	//uint16_t first_white_sum_detected;
	bool ret = false;

	while(!read_frame)
		;

	//enc_latch_count();
	while (processed_line < 240)
	{
		if (processed_line != line_cnt)
		{
		    white_count = 0;
			for (cnt = 0; cnt < 320*2; cnt+=2)
			{
				tmp = __rev16(*(uint16_t *)&image[320*2*processed_line+cnt]);
#if ORIGINAL_DETECTION_LOGIC
				r = (tmp >> 11) & 0x1F;
				g = (tmp >> 5) & 0x3F;
				b = tmp & 0x1F;
#else
				r = (tmp >> 11) & 0x1F;
				r <<= 3;
				g = (tmp >> 5) & 0x3F;
				g <<= 2;
				b = tmp & 0x1F;
				b <<= 3;
#endif

#if ORIGINAL_DETECTION_LOGIC
				if ((b < 14) && (g > 25) && (r < 14) && (processed_line < 200) && (processed_line > 35))
#else
				if ((b < 100) && (r < 100) && (g > 70) && ((g - b) > 5) && ((g - r) > 5) && (processed_line > 35) && (processed_line < 180))
#endif
				{
				    ++white_count;
				    //*(uint16_t *)&image[320*2*processed_line+cnt] = 0xFFFF;
				}
				else
				{
					//*(uint16_t *)&image[320*2*processed_line+cnt] = 0;
				}
			}
#if ORIGINAL_DETECTION_LOGIC
			if ((white_count > 5)/* && (white_count < 35)*/)
#else
			if ((white_count > 20) && (white_count < 30))
#endif
			{
			    ++row_count;
			}
#if !ORIGINAL_DETECTION_LOGIC
			if (row_count == 1)
			{
				first_white_sum_detected = processed_line;
			}
#endif
			if(row_count == 3)
			{
#if ORIGINAL_DETECTION_LOGIC
			    detected_line = processed_line;
#else
			    detected_line = first_white_sum_detected;
#endif
			}

			++processed_line;
		}
	}
	if (row_count > 5)
	    ret = true;

//	if (ret)
//	{
//		int i;
//		for (i = 0; i < 320; i++)
//		{
//			*(uint16_t *)&image[320*2*detected_line+i] = 0xFFFF;
//		}
//	}

	return ret;
}

bool ov7725_detect1(void)
{
	uint16_t processed_line = 0;
	uint16_t cnt;
	uint16_t tmp;
	uint8_t /*r,*/ g, b;
	uint16_t white_count;
	uint16_t row_count = 0;
	bool ret = false;

	if(!read_frame)
	{
		return ret;
	}
	//enc_latch_count();

	while (processed_line < 240)
	{
		if (processed_line != line_cnt)
		{
		    white_count = 0;
			for (cnt = 0; cnt < 320*2; cnt+=2)
			{
				tmp = __rev16(*(uint16_t *)&image[320*2*processed_line+cnt]);
				//g = (tmp >> 5) & 0x3F;
				g = (tmp >> 5) & 0x3F;
				b = tmp & 0x1F;

				if (b < 14 && g > 25)
				    ++white_count;
			}
			if ((white_count > 10)/* && (white_count < 35)*/)
			    ++row_count;

			++processed_line;
		}
	}
	if (row_count > 5)
	{
	    ret = true;
	    skip_frame_cnt = SKIP_FRAME_COUNT;
	}

	return ret;
}

uint16_t ov7725_get_enc_count_adjust(void)
{
	if (detected_line < 240)
		return 1;//pixel_to_enc_count[240-detected_line-1];
	else
		return 0;
}

void ov7725_get_frame_cnt(uint16_t *frame1, uint16_t *frame2)
{
	*frame1 = frame_cnt1;
	*frame2 = frame_cnt2;
}

void vsync_handler(void)
{
    //dbg_printf("VSYNC frame started\n");
	GPIOIntClear(GPIO_PORTP_BASE, GPIO_INT_PIN_0);
	++frame_cnt;
	frame_cnt1 = frame_cnt;

	if (skip_frame_cnt)
	{
		--skip_frame_cnt;
	}
	else
	{
		if (busy)
		{
			line_cnt = 0;
			hw_dma_set_img(&image[320*2*line_cnt]);
			busy = false;
			read_frame = true;
		}
	}
}

void href_handler(void)
{
    //dbg_printf("HREF pixel started\n");
	GPIOIntClear(GPIO_PORTQ_BASE, GPIO_INT_PIN_0);
	if (read_frame)
	{
		if (++line_cnt < 240)
		{
			hw_dma_set_img(&image[320*2*line_cnt]);
		}
		else
		{
			read_frame = false;
		}
	}
}
