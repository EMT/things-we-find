# Things We Find

Public code repository for http://thingswefind.com – A collaborative collection of lovely things powered by the genius that is (GimmeBar)[https://gimmebar.com/].

We designed and built this in a weekend, whilst doing all the usual weekend stuff, so it’s a tad rough-and-ready.

## Here’s how it works

We have a collaborative GimmeBar collection containing all of the stuff that appears on thingswefind.com. We query the public GimmeBar’s API with a simple public method for grabbing the latest stuff added to the collection and display it on the site. The API call is wrapped by the little api.php script included in this repository.

Categories are GimmeBar tags (the kind you add to GimmeBar as #hastags).

## If you’re here about the tags/categories

When you add something to GimmeBar, and you want to place it into one of the categories on thingswefind.com, you do this by adding a tag for each category. 

To add tags in GimmeBar, put them in the description field as #hastags. You can add more than one if you like, seperated by spaces, like this:

    #Spaces #Objects #Colour

Only certain categories will work (and currently any others will break things, so be careful to spell tags properly!) – here’s a list of tags that work:

- Typography
- Illustration
- Spaces
- Print
- Objects
- Colour
- Environments
- Photography
- Miscellany
