<?php

if (! function_exists('image')) {
    function image($url): string
    {
        $noPhotoBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXd3d2ampqXl
        5e9vb3g4ODS0tKUlJTPz8+/v7/W1tavr6/IyMinp6fFxcWsrKyfn5+3t7dEyn0RAAADn0lEQVR4nO2c65qqMAwApYYKKov
        v/7RH96xQoBV0S2878xuJ8wEhKW0PBwAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
        AAIBNSGhC69XdMSxdHVJSul6r0Oi+C6YoX7qKgf4KpChfKopgVakwitLFuYI
        PdJAbVfpoglXVhzCs413C+0Ws9xeULtZT+EAFuE2lMQwDvSiMgMcAhschoOoD
        ve17FcdQ3YJVbDcVxTBIXvsJ2scwDBFsCHoLGDSOYcigGOYfFMNfnt3ezJdi
        KFJfmuZiaebLMJTT+acKrM6n2alLMJT2qsfaTF/byckLMLx3LJOWRU2biPwNpVk0n
        boxTp+9oXVgxByxyN6wtTbVqt01qJMdgsnVbngdAuRueHKM/OjTjkHd+A8mZ8fIjz
        o/I+RuaPd7UIhh7Ry8U8+xw7wN5eI2vMhOQV/+Ie+GjduwwXAPuEvfp/hM8wfeFuW
        /8cuv2v5A5Z1597Rluk/OHbAcjr3W17Uvt/mOYkhdfR+tr2sH5joSNTxgRtZwnDbT
        0cRxYsr6ZJ8cR4Qnb4Hx9e0+PrdR/Vmtom5bMlNOX2YW+VFvUfxlUB9sDSbLWmzy
        AtglqBe2BrPVKR9PvEvScOn3ULx89gcTNHQU05Wavwd8BvXEpmDjJKaFYvvJX0zO
        0FJmjrTWX6zk5cQMLWnUxPaD4+3lE5qaob3dG+7Tfn7Gw70kVS+L89QMV6ZJz6rw
        Z/+xMH8vqD9Wg7nSqENxHC590X8kZehOo4biWIXLcXxm3YopGW5bqzAoytk83Nli
        JWQop/Ur+KMo3zlmerir/0jI8HUaNV36rq5van64o/9IyPCN1SbTSfiDov3eT8XQx
        4ooa/+RiuGWNLpB0VLdJGLoa8mXXvYfaRiK+zvgmyxbrDQM7T3vZ4rzFisNQ6+L9t
        qNQQMael5Y2m8KGtLQWO/lhVmjEd9QLr6XXU6r8OiG/tKoQzG6occ0aigajUZsw/W
        e9zNFs4uMauicLfJrxaHRiGtodume0UnMa/OfRk3FTqxBQxrK5p73M8X/jUbUa7in
        X/VsNCIa7pRGDVQtMQ13S6Om4r3RiGb48guMP9p4hnumUZNYhs2+aXRE9cNc8MDXMN
        hGNeoaxbAKdAUnscIaxgBDDDHEEEMMMcQQQwwxLMaw+L0vy9+/9A/sQVv+PsLl7wV
        9KH8/70P5e7Ifyt9X/79kYMLqAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQL78AzYYQhHIq/FbAAAAAElFTkSuQmCC';

        return strpos($url, 'http') === false || strpos($url, 'https') === false ? (Storage::disk('public')->exists($url) ? Storage::url($url) : "data:image/png;base64, $noPhotoBase64") : $url;
    }
}
