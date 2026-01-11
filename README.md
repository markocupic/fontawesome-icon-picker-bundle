![Logo](https://github.com/markocupic/markocupic/blob/main/logo.png)

# Font Awesome Icon Picker form widget for Contao CMS

<img src="docs/images/backend.png" width="600">

## Configuration

Out of the box, the bundle uses the free version of [Font Awesome](https://fontawesome.com/icons) and does not require any configuration.
But you can also use the Pro version by changing the configuration in your `config/config.yaml` file.

```yaml
markocupic_fontawesome_icon_picker:
  # Use your custom Font Awesome (Pro) version here:
  fontawesome_source_path: 'https://kit.fontawesome.com/12345sdf65.js' # or a local path: files/fontawesome-pro/js/all.min.js
  # Set the version of Font Awesome you want to use.
  fontawesome_version: '7.0.1'
  # Set the allowed styles
  fontawesome_allowed_styles:
    - fa-solid
    - fa-regular
    - fa-light
    - fa-brands
    - fa-duotone
    - fa-thin
  # Add the path to your custom fontawesome icons meta file.
  fontawesome_meta_file_path: 'files/fontawesome-pro/metadata/icons.yml'
```
