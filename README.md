Pareekshit Ravi
ravip2
001407109

register.html is the first page
Also available at http://pareekravi.com/ParkingManager/register

Bonous 1 and Bonous 2 have been completed

I have used two different sizes of the logo image. The images have different resolutions which allow them to not need to be altered too much based on the display they are being viewed on. It is important to have different versions because for images which are not very high resulution, but are then viewed on a high res display. This will cause the image to be too small to even see and is not useful. 

A benefit of using <picture> is that most of the scaling will be taken care of because of the viewport. Another benefit is that the same image can be shown differently on differnt devices. For example an image shown on a computer will take up the full screen, but normally viewing that same image on a phone or tablet will cause the image to either stretch or have white lines. Both make the image look very bad, but we can say to use an alternate image in those situations with <piucture>. Another benefit is the image displayed can change based on the size of the device. If the image that is shown is the type of device (phone, tablet, computer), using this we can change the source of the image and select the one we want to show based on the width. That fact that image can be changed based on whether it is in landscape or portrait is a huge benefit in order the make the image show in its best resulution and orientation. An advantage is that when the website is of a lower resolution, it will not need to download such a large image file when it is not needed for the display's size. 

A negative to this is that in most cases it is actually missused. The only times that it should be used is when there is a resulution switching and when there is art direction (crop images to smaller screens). It is not always needed to use <picture> for selecting different images based on screen size because that feature exists in <img>. There are very few cases in responsive design that this is even needed. <img> has <srcset> to identify which image to use based on screen size. 