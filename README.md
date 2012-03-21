## Campaign Monitor for MODx

Campaign Monitor for MODx (CMx) is a component for MODx that allows you to send and check your email campaigns directly from the MODx backend interface.

## Configuration

After installing using the provided build script:

1. Enter your API Key into the 'cmx.api_key' system setting.  This can be found in the Campaign Monitor manager interface.
2. Enter your Client ID into the 'cmx.client_id' system setting.  Also can be found in the Campaign Monitor manager interface.

## Things to add

While it's currently possible to create and view campaign info, this package is still in need of quite a bit of work.  Current things I'd like to add:

* Ability to edit drafts:
  	This will require a full delete of the draft campaign and then the creation of a new campaign with the old data pulled in.  I'm currently caching the campaign data (there's no way to pull in all the campaign fields through the API), so this should be quite possible.

* Campaigns using resource content: 
	The idea is to be able to pull information from MODx resources directly into the campaign content field.  Ultimately I'd like to get it working with Custom Resource Classes, for things like articles, press releases, etc that would normally go into email campaigns.

* List Management:
	Allow for the management of subscriber lists and segments.