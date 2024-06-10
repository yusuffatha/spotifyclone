<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify</title>
    <link rel="stylesheet" href="playlist.css">
    <link rel="icon" href="assets/spotify-logo.png" type="img/png">
    <script src="https://kit.fontawesome.com/0835df0ce7.js" crossorigin="anonymous"></script>
</head>  
<body>

    <div class="sidebar">
      <div class="logo">
        <a href="HomeAfter.php">
          <img src="https://storage.googleapis.com/pr-newsroom-wp/1/2018/11/Spotify_Logo_CMYK_Green.png" alt="Logo" />
        </a>
      </div>

      <div class="navigation">
        <ul>
          <li>
            <a href="HomeAfter.php">
              <span class="fa fa-home"></span>
              <span>Home</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="fa fa-search"></span>
              <span>Search</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="fa fas fa-book"></span>
              <span>Your Library</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="navigation">
        <ul>
          <li>
            <a href="#">
              <span class="fa fas fa-plus-square"></span>
              <span>Create Playlist</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="fa fas fa-heart"></span>
              <span>Liked Songs</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="policies">
        <ul>
          <li>
            <a href="#">Cookies</a>
          </li>
          <li>
            <a href="#">Privacy</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="main-container">
        <div class="header">
            <div class="topbar">
                <div class="prev-next-buttons">
                    <button type="button" class="fa fas fa-chevron-left"></button>
                    <button type="button" class="fa fas fa-chevron-right"></button>
                </div>
            </div>
            
            <div class="playlist-content">
              <?php
              $servername = "localhost";
              $username = "root"; // your MySQL username
              $password = ""; // your MySQL password
              $dbname = "spotifylite";

              // Create connection
              $conn = new mysqli($servername, $username, $password, $dbname);

              // Check connection
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              
              // Query SQL untuk mencari playlist berdasarkan judul
              $sql = "SELECT * FROM playlist WHERE Id = '1'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<div class='playlist-cover'>
                                <a href='{$row['otherpageurl']}'><img src='{$row['thumbnail']}'></a>
                            </div>
                            <div class='playlist-info'>
                              <div class='playlist-public'>PUBLIC PLAYLIST</div>
                              <div class='playlist-title'>
                                <p>{$row['title']}</p>
                              </div>
                              <div class='playlist-user'>
                                <p>{$row['username']}</p>
                              </div>
                              <div class='playlist-description'>
                                <p>{$row['description']}</p>
                              </div>
                              <div style='height: 10px;'></div>
                              <div class='playlist-stats'>
                                <img src='assets/spotify-logo.png' width='24px' height='24px' alt=''>
                                <span> Spotify ·</span>
                                <span>5,131,321 likes · </span>
                                <span>100 songs, </span>
                                <span>6 hr 57 min </span> 
                              </div>
                              <div style='height: 10px;'></div>
                            </div>";
                  }
              } else {
                  echo "No playlist found";
              }

              
              ?>
            </div>     
        </div>
        
        <div class="playlist-songs-container">
            <div class="playlist-buttons">
                <div class="playlist-buttons-left">
                    <div class="playlist-buttons-resume-pause">
                        <img src="assets/Pause.svg" alt="">
                    </div>
                    <div class="playlist-buttons-like">
                        <img src="assets/FiiledLike.svg" alt="" class="spotify-color">
                    </div>
                    <div class="playlist-buttons-download">
                        <a href="addSong.php"><img src="assets/Download.svg" alt=""></a>  
                    </div>
                </div>
                <div class="playlist-buttons-right">
                    <div class="playlist-buttons-search">
                        <img src="assets/Search.svg" alt="">
                    </div>
                    <div class="playlist-buttons-order">
                        Custom Order
                    </div>
                </div>
            </div>
            
            <div class="playlist-songs">
    <table>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Album</th>
            <th>Date Added</th>
            <th>Play Back</th>
            <th></th>
        </tr>
        <?php
        // Membuat koneksi
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "spotifylite";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Mengecek koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query untuk mengambil data dari database termasuk id
        $sql = "SELECT id, title, artist, audio_data, filename, upload_date, profile_photo FROM audio_files";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Menampilkan data untuk setiap baris hasil query
            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $title = $row['title'];
                $artist = $row['artist'];
                $audioData = base64_encode($row['audio_data']);
                $fileName = $row['filename'];
                $uploadDate = date("F d, Y", strtotime($row['upload_date'])); 
                $profilePhotoData = base64_encode($row['profile_photo']);
        
                echo "<tr>
                        <td>$id</td>
                        <td class='song-title'>
                            <div class='song-image'>
                                <img src='data:image/jpeg;base64,$profilePhotoData' alt='Profile Photo'>
                            </div>
                            <div class='song-name-album'>
                                <div class='song-name'>$title</div>
                                <div class='song-artist'>$artist</div>
                            </div>
                        </td>
                        <td class='song-album'>Spotify</td> 
                        <td class='song-date-added'>$uploadDate</td> 
                        <td class='song-audio'>
                            <audio controls>                      
                                <source src='data:audio/mpeg;base64,$audioData' type='audio/mpeg'>
                                Your browser does not support the audio element.
                            </audio>                                    
                        </td>
                        <td>
                            <form method='post' action='deleteSong.php'>
                                <input type='hidden' name='id' value='$id'>
                                <button type='submit' style=' border: none; cursor: pointer;'>
                                    <i class='fa-regular fa-trash-can'></i>
                                </button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table> 
</div>

</body>