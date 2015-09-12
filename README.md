# Logbook

Adds simple change logs to eloquent models through a convenient interface and trait.

## Usage

In any eloquent model you want to track changes, implement the Bmartel\Logbook\LoggableContract and use the Bmartel\Logbook\Loggable trait.
By default Logbook will watch your fillable properties, but you can supply your own properties by overriding the $loggable array in each Loggable model.

## Credits

Brandon Martel - Maintainer