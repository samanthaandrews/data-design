<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 1/11/18
 * Time: 1:18 PM
 */
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Data Design Project</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<h1>Data Design - Medium</h1>
		<div class="persona">
			<img class="persona" src="Images/woman-gloria-persona.jpeg" alt="Photo of Gloria" width="400"/>
			<h2>Persona</h2>
			<p>Gloria Fisher</p>
			<p>Woman</p>
			<p>51 years old, has three adult children</p>
			<p>iPad Pro, 10.5”, with detachable keyboard, intermediate user (the iPad is new to Gloria but she is a long
				time user of Apple mobile devices and computers)</p>
			<p>Gloria is a Physics Professor at a large, public University. This year, she is starting a two year
				sabbatical. During her time off, she will travel around the world in an attempt to identify every bird
				species. She wants to write blog posts about her bird watching adventures using Medium as her blogging
				platform. She chose Medium because her youngest daughter (age 21) said it was simple to use. Gloria wants to
				focus on writing and posting photos rather than learning to manage her own website. She decided that the
				iPad was best portable device for her journey around the world, since it is smaller and lighter than a
				laptop.</p>
			<h2>User Story</h2>
			<p>As a Medium account holder, I want to publish blog posts.</p>
		</div>

		<br>
		<br>

		<div class="usecases">
			<h2>Use Cases and Interaction Flow</h2>
			<p>Gloria is ready to make her first blog post after touching down in Argentina and going on a group birding
				outing. She has already created an account with username @GloriaBirdWatching.</p>
			<p><em>precondition:</em> Gloria has created and verified her Medium account</p>
			<p><em>postcondition:</em> Gloria successfully makes her first post on Medium</p>
			<ul>
				<li>Gloria logs in to her Medium account</li>
				<li>Medium prompts Gloria to write her first story</li>
				<li>She clicks the <em>write story</em> button</li>
				<li>Medium loads a blank article page</li>
				<li>She adds her content (text and photo)</li>
				<li>She clicks publish</li>
				<li>Medium takes her to the published article page</li>
				<li>Her blog is now live</li>
			</ul>
			<p>Other users can now comment on the post (at the bottom or in-line), “clap” for the post, tweet it (or tweet
				specific passages), share on Facebook, bookmark it, and highlight passages (publicly or privately).</p>
		</div>

		<h2>Visual Data Design</h2>

		<div>
			<h2>Conceptual Model</h2>
			<img src="Images/Medium-Profile-Image.png" alt="Medium Profile" width="500"/>
			<img src="Images/Medium-Story-Image.png" alt="Medium Story" width="500"/>
		</div>

		<div>
			<h3>Entities and Attributes</h3>
			<h4>Profile (Strong)</h4>
			<ul>
				<li>profileId (primary key)</li>
				<li>profileActivationToken</li>
				<li>profileHandle</li>
				<li>profileEmail</li>
				<li>profileHash</li>
				<li>profileSalt</li>
			</ul>
			<h4>Story (Strong)</h4>
			<ul>
				<li>storyId (primary key)</li>
				<li>storyProfileId (foreign key)</li>
				<li>storyContent</li>
				<li>storyDateTime</li>
			</ul>
			<h4>Clap (Try Hard)</h4>
			<ul>
				<li>clapId (primary key)</li>
				<li>clapProfileId (foreign key)</li>
				<li>clapStoryId (foreign key)</li>
			</ul>
			<h4>Highlight (Weak)</h4>
			<ul>
				<li>highlightProfileId (foreign key)</li>
				<li>highlightStoryId (foreign key)</li>
				<li>highlightDateTime</li>
			</ul>
			<h3>Relations</h3>
			<ul>
				<li>One <strong>Profile</strong> can write many <strong>Stories</strong> - <strong><em>(1 to
							n)</em></strong></li>
				<li>Many <strong>Profiles</strong> can clap for many <strong>Stories</strong> - <strong><em>(m to
							n)</em></strong></li>
				<li>Many <strong>Profiles</strong> can highlight many <strong>Stories</strong> - <strong><em>(m to
							n)</em></strong></li>
			</ul>
		</div>
		<h2>ERD</h2>
	</body>
</html>