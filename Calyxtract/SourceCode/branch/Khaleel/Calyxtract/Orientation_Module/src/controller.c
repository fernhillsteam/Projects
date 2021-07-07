/*
 * controller.c
 *
 *  Created on: Jul 1, 2021
 *      Author: yallo
 */
#define TARGET_IS_TM4C129_RA1
#include <stdint.h>
#include <stdbool.h>
#include "inc/hw_ints.h"
#include "inc/hw_types.h"
#include "inc/hw_memmap.h"
#include "inc/hw_udma.h"
#include "inc/hw_ssi.h"
#include "driverlib/debug.h"
#include "driverlib/gpio.h"
#include "driverlib/qei.h"
#include "driverlib/interrupt.h"
#include "driverlib/pin_map.h"
#include "driverlib/rom.h"
#include "driverlib/rom_map.h"
#include "driverlib/sysctl.h"
#include "driverlib/udma.h"
#include "driverlib/ssi.h"
#include "driverlib/uart.h"

#include "inc/hardware.h"
#include "inc/RS_232.h"
#include "inc/encoder.h"
#include "inc/pneumatic.h"
#include "inc/sccb.h"
#include "inc/ov7725.h"

#define channel1 1
#define channel2 2
#define channel3 3


uint8_t good_chilli, bad_chilli;
uint8_t entry_sensor;
uint8_t chilli_pod_detected = 0;
uint8_t R_orient, L_orient;
uint8_t channelizer_pos = 1;

uint8_t controller ()
{
    while(true){
    //camera pulse, if chilli is detected. It can be accept pulse/reject pulse
    if (chilli_pod_detected == 1)
        {
            if(good_chilli == 1)//chilli accepted
            {
                pod_accept_on();
                wait_up();
                pod_accept_off();
            }//if(good_chilli == 1)
            else if (bad_chilli == 1)//chilli rejected
            {
                pod_reject_on();
                wait_up();
                pod_reject_off();

            }//else if (bad_chilli == 1)
        }//if (chilli_pod_detected == 1)

    //Orientation of chilli's
    if(R_orient == true)
    {
        pod_tilter_down();
        //Stepper_CW();
        wait_up();
        pod_tilter_up();
    }//if(R_orient == true)
    else if(L_orient == true)
    {
        pod_tilter_down();
        //Stepper_CCW();
        wait_up();
        pod_tilter_up();
    }//else if(L_orient == true)


    //Channelizer
    if (!(entry_sensor == 1))
    {
      switch(channelizer_pos)
      {
      case channel1 :
          wait_up();
          break;

      case channel2 :
          channelizer_fwd();
          wait_up();

          break;

      case channel3 :
          channelizer_rev();
          wait_up();
          break;


      }//switch
    }//if(entry_sensor)

    //Return the encoder details

    }//while(true)
}//controller
