-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2026 at 04:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbim`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_free` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `slug`, `author`, `description`, `cover_image`, `content`, `category`, `pages`, `price`, `is_free`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Walking with the Holy Spirit', 'walking-with-holy-spirit', 'DBIM Leadership', 'A foundational guide for every believer.', NULL, 'Chapter 1: The Beginning\n\nWalking with the Holy Spirit is not just a destination but a continuous journey of faith. In this book, we explore how to listen to the gentle voice of God...\n\nChapter 2: The Fruits\n\nAs we grow in our relationship, we begin to see the evidence of His presence in our lives through love, joy, and peace...', NULL, NULL, 0.00, 1, 1, '2026-02-03 19:15:23', '2026-02-03 19:15:23'),
(2, 'Understanding Spiritual Warfare', 'understanding-spiritual-warfare', 'Apostle J. Doe', 'Advanced teaching on the hidden battles.', NULL, 'Spiritual warfare is a reality that many choose to ignore, yet it affects every aspect of our existence. To be victorious, one must understand the weapons of our warfare which are not carnal but mighty through God to the pulling down of strongholds...', NULL, NULL, 3000.00, 0, 1, '2026-02-03 19:15:23', '2026-02-03 19:15:23'),
(3, 'The God Dimention', 'the-god-dimention', 'Iheanyichukwu Ikenna', 'the bible said that we are god', 'assets/images/books/1770359258.png', 'here is a brief', 'Faith', 100, 0.00, 1, 1, '2026-02-06 05:27:38', '2026-02-06 05:27:38'),
(4, 'Biblical Business Principle', 'biblical-business-principle', 'Dr. Spiritual Mentor', 'A comprehensive guide to building a kingdom-based business enterprise centered on divine principles and ethical integrity.', NULL, 'True business success begins with the understanding that we are managers, not owners. In Luke 16:11, the Bible asks, \'Therefore if you have not been faithful in the unrighteous mammon, who will commit to your trust the true riches?\' Stewardship is the conscious recognition that every resource—capital, talent, and time—belongs to God. When a businessman views his company as a divine assignment, his decision-making shifts from short-term greed to long-term kingdom impact. This foundation requires a heart that is not tied to the money but to the Master. You must ask yourself daily: \'How would Jesus manage this department?\' Stewardship also involves accountability. Just as the servants in the parable of the talents had to account for their multiplication, we must ensure that our businesses are growing and bearing fruit that honors the Creator.', 'Leadership', 96, 0.00, 1, 1, '2026-02-06 06:10:02', '2026-02-06 06:10:02'),
(5, 'The Skilful Prayer', 'the-skilful-prayer', 'Apostle of Faith', 'Unlocking the strategic dimensions of prayer to experience consistent results and deeper intimacy with the Father.', NULL, 'Prayer is not a public performance; it is a private communion. Matthew 6:6 instructs, \'But you, when you pray, go into your room, and when you have shut your door, pray to your Father who is in the secret place.\' The secret place is where the noise of the world is silenced and the frequency of heaven is heard. It is a place of vulnerability and honesty. In the secret place, masks are dropped and hearts are laid bare. It is here that spiritual strength is renewed and divine strategies are downloaded. Intimacy precedes impact. Before you can stand before men, you must first kneel before God.', 'Devotional', 96, 0.00, 1, 1, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(6, 'The Effective Leadership', 'the-effective-leadership', 'Bishop Wisdom', 'Modeling leadership after the patterns of Christ and the great biblical reformers to influence generations.', NULL, 'Leadership is not a title; it is a trust. The foundation of any effective leader is character. In the book of Nehemiah, we see a leader whose integrity was so strong that even his enemies couldn\'t find a valid accusation against him. Character is what you do when no one is watching. It is the consistency between your public persona and your private life. A leader without character is like a ship without a rudder; they might have the wind of talent, but they will eventually crash on the rocks of compromise. High-capacity leadership requires high-integrity living. If your character cannot sustain your gift, your gift will eventually destroy you.', 'Leadership', 96, 0.00, 1, 1, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(7, 'Choosing the Right Partner to Marry', 'choosing-the-right-partner-to-marry', 'Pastor Mark & Sarah', 'A biblical framework for selecting a life partner that aligns with your spiritual destiny and emotional well-being.', NULL, '2 Corinthians 6:14 is the primary anchor for marital selection: \'Do not be unequally yoked together with unbelievers.\' Marriage is the merging of two lives into one. If your spirits are moving in different directions, your life will be filled with friction. Spiritual compatibility is more than just attending the same church. it is about a shared commitment to the Lordship of Christ. When both partners have the same Master, they have a common ground for resolution and growth. Don\'t settle for someone you hope to change; choose someone whose walk with God inspires your own.', 'Faith', 96, 0.00, 1, 1, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(8, 'Believe: The Gateway to the Supernatural', 'believe-the-gateway-to-the-supernatural', 'Prophet of Grace', 'Exploring the mechanics of faith and the spiritual laws that govern the manifestation of the supernatural in a believers life.', NULL, 'Hebrews 11:1 defines faith as \'the substance of things hoped for, the evidence of things not seen.\' Faith is the bridge between the invisible realm of the Spirit and the visible realm of the physical. It is how we reach into the treasury of heaven and pull out our provision. Believe is a verb—it is an action. To believe is to act as if the Word of God is true, regardless of what your senses tell you. Your physical eyes see the mountain, but your spiritual eyes see the mountain removed. Faith is not denial of reality; it is the invitation of a higher reality.', 'Faith', 96, 0.00, 1, 1, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(9, 'the text subject', 'the-text-subject', 'Iheanyichukwu Ikenna', NULL, NULL, 'Initial draft content.', 'Theology', NULL, 0.00, 1, 1, '2026-02-06 21:37:56', '2026-02-06 21:37:56'),
(10, 'The Divine Strategy', 'the-divine-strategy', 'Admin User', 'A masterclass in navigating modern ministerial challenges with spiritual precision.', 'https://images.unsplash.com/photo-1544648151-1823ed4117ff?auto=format&fit=crop&q=80&w=400', NULL, 'Leadership', NULL, 5000.00, 1, 1, '2026-02-10 05:37:59', '2026-02-10 05:37:59'),
(11, 'Kingdom Impact', 'kingdom-impact', 'Admin User', 'Principles for scaling your ministry in the digital age.', 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=400', NULL, 'Strategy', NULL, 0.00, 1, 1, '2026-02-10 05:37:59', '2026-02-10 05:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `book_chapters`
--

CREATE TABLE `book_chapters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_chapters`
--

INSERT INTO `book_chapters` (`id`, `book_id`, `title`, `slug`, `content`, `order`, `created_at`, `updated_at`) VALUES
(1, 3, 'ye are gods', 'ye-are-gods', '', 1, '2026-02-06 05:54:01', '2026-02-06 05:54:01'),
(2, 3, 'accessing the god dimention', 'accessing-the-god-dimention', '', 2, '2026-02-06 05:55:03', '2026-02-06 05:55:03'),
(3, 4, 'The Foundation of Stewardship', 'the-foundation-of-stewardship', 'True business success begins with the understanding that we are managers, not owners. In Luke 16:11, the Bible asks, \'Therefore if you have not been faithful in the unrighteous mammon, who will commit to your trust the true riches?\' Stewardship is the conscious recognition that every resource—capital, talent, and time—belongs to God. When a businessman views his company as a divine assignment, his decision-making shifts from short-term greed to long-term kingdom impact. This foundation requires a heart that is not tied to the money but to the Master. You must ask yourself daily: \'How would Jesus manage this department?\' Stewardship also involves accountability. Just as the servants in the parable of the talents had to account for their multiplication, we must ensure that our businesses are growing and bearing fruit that honors the Creator.', 1, '2026-02-06 06:10:02', '2026-02-06 06:10:02'),
(4, 4, 'The Law of the Seed', 'the-law-of-the-seed', 'Genesis 8:22 declares, \'While the earth remains, seedtime and harvest... shall not cease.\' In the biblical business model, every investment is a seed. You cannot expect a harvest where you have not planted. This law applies to financial capital, but also to kindness, service, and value. If you want a loyal customer base, you must first plant seeds of exceptional service. The principle of the seed requires patience. Many entrepreneurs fail because they want the harvest in the same season they planted the seed. However, the spiritual law dictates that there is a \'time\' between the seed and the harvest. During this waiting period, your faith keeps the seed in the ground. Multiplication happens when the seed dies to its original form and rises as a fruitful tree.', 2, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(5, 4, 'Integrity: The Business Currency', 'integrity-the-business-currency', 'Proverbs 11:1 tells us that \'Dishonest scales are an abomination to the Lord, but a just weight is His delight.\' In a world where cutting corners is often celebrated, the believer must stand on the rock of integrity. Integrity is not just about being legal; it is about being biblical. It means keeping your word even when it hurts your profit margin (Psalm 15:4). When customers know that your \'yes\' is \'yes\' and your \'no\' is \'no,\' they develop a level of trust that no marketing budget can buy. Your brand is ultimately a reflection of your character. A business built on deception is like a house built on sand; it might look grand for a moment, but it will surely crumble under the pressure of the storm.', 3, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(6, 4, 'Diligence and Excellence', 'diligence-and-excellence', 'Diligence is the engine of promotion. Proverbs 22:29 says, \'Do you see a man who excels in his work? He will stand before kings; he will not stand before unknown men.\' Biblical business success is not just about prayer; it is about the pairing of spiritual devotion with professional excellence. Excellence is doing a common thing in an uncommon way. It is the refusal to settle for \'good enough.\' When Joseph was in Egypt, his excellence made him indispensable to Pharaoh. Whether you are coding a software, baking bread, or managing a global supply chain, your work should be a testimony of the God you serve. Diligence means being consistent, being punctual, and being proactive.', 4, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(7, 4, 'Multiplication vs. Addition', 'multiplication-vs-addition', 'God is the God of multiplication. In the parable of the talents (Matthew 25), the master expected a return on the investment. Addition is a linear process, but multiplication is exponential. In business, multiplication happens through systems, delegation, and divine favor. You cannot multiply what you cannot manage. For a business to scale, it must move beyond the personality of the founder. Principles of multiplication require the courage to take risks. The servant who hid his talent was reprimanded because fear is the enemy of multiplication. To enter the \'joy of the master,\' one must be willing to trade and expand the resources given.', 5, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(8, 4, 'Dealing with Debt', 'dealing-with-debt', 'The Bible warns that \'the borrower is servant to the lender\' (Proverbs 22:7). While the modern financial world is built on leverage, the biblical principle encourages a debt-free lifestyle. Debt creates a burden that can hinder your ability to obey God\'s leading. Romans 13:8 instructs us to \'Owe no one anything except to love one another.\' A kingdom business aims to be the lender, not the borrower. This requires disciplined financial planning and avoiding the snare of consumerism. Financial freedom allows a business to be agile and responsive to the whispers of the Holy Spirit.', 6, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(9, 4, 'Divine Connection and Partnerships', 'divine-connection-and-partnerships', 'Ecclesiastes 4:9 says, \'Two are better than one, because they have a good reward for their labor.\' In business, who you walk with determines where you end up. However, the Bible also warns against being \'unequally yoked\' (2 Corinthians 6:14). Divine connections are relationships orchestrated by God to accelerate your purpose. A kingdom partnership is one where both parties are aligned in values and vision. It is not just about merging assets; it is about merging spirits. When God brings a Barnabas or a Timothy into your business life, cherish the relationship and nurture it with mutual respect.', 7, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(10, 4, 'Generosity in the Marketplace', 'generosity-in-the-marketplace', 'The ultimate goal of a biblical business is to become a channel of blessing. Luke 6:38 promises, \'Give, and it will be given to you: good measure, pressed down, shaken together, and running over.\' Generosity is the antidote to the spirit of Mammon. Whether through tithing, supporting missions, or helping the poor, a generous business invites the protection and provision of God. Generosity also extends to how you treat your employees. Paying fair wages and providing for their needs is a scriptural mandate (James 5:4). A business that gives is a business that God can trust with more.', 8, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(11, 5, 'Understanding the Secret Place', 'understanding-the-secret-place', 'Prayer is not a public performance; it is a private communion. Matthew 6:6 instructs, \'But you, when you pray, go into your room, and when you have shut your door, pray to your Father who is in the secret place.\' The secret place is where the noise of the world is silenced and the frequency of heaven is heard. It is a place of vulnerability and honesty. In the secret place, masks are dropped and hearts are laid bare. It is here that spiritual strength is renewed and divine strategies are downloaded. Intimacy precedes impact. Before you can stand before men, you must first kneel before God.', 1, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(12, 5, 'The Power of Fasting', 'the-power-of-fasting', 'Fasting is not an attempt to change God; it is an exercise to change us. It is the putting down of the flesh so that the spirit can arise. Isaiah 58 describes the \'chosen fast\' that breaks the bands of wickedness and undoes heavy burdens. When we fast, we are declaring that our hunger for God is greater than our hunger for food. Fasting sensitizes our spiritual ears. It clears the static of carnal desires and allows us to perceive the subtle leanings of the Holy Spirit. A skilful prayer life often incorporates regular seasons of fasting to maintain spiritual sharpenss.', 2, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(13, 5, 'Praying the Word', 'praying-the-word', 'The word of God is the legal ground for prayer. Hebrews 4:12 says the Word is \'living and powerful.\' When you pray the Word, you are bringing God\'s own promises back to Him. It is like an attorney citing the law in a courtroom. God is bound by His Word (Psalm 138:2). Therefore, the most effective prayers are those saturated with scripture. Instead of just complaining about your problems, find a verse that addresses the situation and declare it with authority. The Word is the sword of the Spirit; without it, your prayer life is defenseless.', 3, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(14, 5, 'Persistent Intercession', 'persistent-intercession', 'Luke 18:1 tells us that \'men always ought to pray and not lose heart.\' Persistence is the proof of desire. Some answers come immediately, but others require a \'laboring\' in the spirit. Think of Elijah on Mount Carmel, praying seven times before the cloud appeared. Persistence is not pestering a reluctant God; it is standing in faith until the manifestation occurs. Intercession is the act of standing in the gap for others. It is the highest form of prayer because it is selfless. When you intercede, you are partnering with Jesus, our Great High Priest, who ever lives to make intercession for us.', 4, '2026-02-06 06:10:03', '2026-02-06 06:10:03'),
(15, 5, 'The Language of the Spirit', 'the-language-of-the-spirit', '1 Corinthians 14:2 explains, \'For he who speaks in a tongue does not speak to men but to God.\' Praying in the Spirit is a supernatural tool for building up your inner man (Jude 1:20). It allows you to pray beyond your mental limitations. There are times when \'we do not know what we should pray for as we ought,\' and that is when the Holy Spirit helps our weaknesses with groanings that cannot be uttered (Romans 8:26). Skilful prayers leverage this gift to tap into the mysteries of the Kingdom and to offer perfect prayers that bypass human intellect.', 5, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(16, 5, 'Spiritual Warfare in Prayer', 'spiritual-warfare-in-prayer', 'Ephesians 6:12 reminds us that \'we do not wrestle against flesh and blood, but against principalities, against powers.\' Prayer is a battlefield. There are spiritual resistances that try to block your answers, much like the Prince of Persia hindered Daniel\'s answer for twenty-one days (Daniel 10:13). Skilful warfare involves wearing the whole armor of God and using the authority of the name of Jesus to bind and loose. It is not shouting at the devil; it is enforcing the victory of the Cross. When you understand your authority, your prayers become decrees that shift the atmosphere.', 6, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(17, 5, 'Hearing the Voice of God', 'hearing-the-voice-of-god', 'Prayer is a dialogue, not a monologue. John 10:27 says, \'My sheep hear My voice, and I know them, and they follow Me.\' A major part of skilful prayer is the ability to be still and listen. God speaks through the \'still small voice,\' through the Word, and through inner witnesses. After you have poured out your heart, give space for the Father to speak back. Carry a journal with you. Write down the impressions, images, or verses that come to your mind. Hearing God\'s voice transforms prayer from a religious ritual into a vibrant relationship.', 7, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(18, 5, 'Result-Oriented Prayer', 'result-oriented-prayer', 'James 5:16 declares, \'The effective, fervent prayer of a righteous man avails much.\' We are not called to pray for the sake of praying; we are called to get results. Biblical prayer has an objective. Whether it is healing, provision, or direction, you should expect to see the answer. This requires faith and a heart that is aligned with the will of God. If we ask anything according to His will, He hears us (1 John 5:14). Result-oriented prayer is marked by a confidence that the Father is both able and willing to intervene in the affairs of His children.', 8, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(19, 6, 'Character: The Root of Influence', 'character-the-root-of-influence', 'Leadership is not a title; it is a trust. The foundation of any effective leader is character. In the book of Nehemiah, we see a leader whose integrity was so strong that even his enemies couldn\'t find a valid accusation against him. Character is what you do when no one is watching. It is the consistency between your public persona and your private life. A leader without character is like a ship without a rudder; they might have the wind of talent, but they will eventually crash on the rocks of compromise. High-capacity leadership requires high-integrity living. If your character cannot sustain your gift, your gift will eventually destroy you.', 1, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(20, 6, 'Service: The Heart of the King', 'service-the-heart-of-the-king', 'Jesus redefined leadership when He said, \'The Son of Man did not come to be served, but to serve\' (Matthew 20:28). In the Kingdom, the way up is down. Servant-leadership is not a strategy; it is a heart condition. It means putting the needs of the team and the mission above personal comfort. When Jesus washed the disciples\' feet, He was demonstrating that no task is too menial for a true leader. Effective leaders don\'t use people to build their vision; they use their vision to build people. When you serve those you lead, you earn a level of loyalty that command-and-control styles can never achieve.', 2, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(21, 6, 'Purpose and Vision Casting', 'purpose-and-vision-casting', 'Proverbs 29:18 warns, \'Where there is no vision, the people perish.\' A leader\'s primary job is to see further and clearer than others. Vision is a mental picture of a preferable future. But vision alone is not enough; a leader must be able to cast that vision effectively. This involves communicating the \'why\' behind the \'what.\' When people understand the purpose, they are willing to endure the process. Vision casting requires clarity, passion, and repetition. You must keep the vision before the people until it becomes part of their own heartbeat. A shared vision is a powerful force for unity.', 3, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(22, 6, 'Team Building and Delegation', 'team-building-and-delegation', 'Exodus 18 shows Jethro advising Moses to delegate tasks. No leader is meant to be a \'one-man show.\' Effective leadership is about identifying the gifts in others and Empowering them to lead in their areas of strength. Delegation is not just offloading work; it is developing people. It requires the humility to accept that someone else might do the task differently (and perhaps better) than you. Building a team means creating a culture of trust and collaboration. A leader is only as strong as the people they surround themselves with. Your ultimate legacy is measured by the leaders you leave behind.', 4, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(23, 6, 'Conflict Resolution and Wisdom', 'conflict-resolution-and-wisdom', 'Conflicts are inevitable in any organization. James 3:17 describes the \'wisdom that is from above\' as being pure, peaceable, gentle, and willing to yield. An effective leader does not avoid conflict but manages it with grace and truth. This requires the ability to listen to all sides without prejudice. Resolution is not about finding who is right, but finding what is right for the mission. It involves tough conversations and sometimes difficult decisions. A leader who can navigate the waters of disagreement without sinking the ship of unity is a leader of great value.', 5, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(24, 6, 'Accountability and Feedback', 'accountability-and-feedback', 'Accountability is the safeguard of leadership. Even King David had a Nathan to speak truth to his life. No leader is above the law or above correction. Effective leaders create systems of accountability where they are answerable to others. Feedback is the breakfast of champions. A leader who stops listening to feedback has stopped growing. Cultivate a culture where people feel safe to share their thoughts and where truth is valued over flattery. Accountability keeps your feet on the ground and your eyes on the goal.', 6, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(25, 6, 'Resilience in the Face of Opposition', 'resilience-in-the-face-of-opposition', 'Leadership often attracts criticism. Nehemiah faced Sanballat and Tobiah, who ridiculed his work. Resilience is the ability to stay focused on the wall despite the noise of the mockers. 2 Corinthians 4:8-9 says, \'We are hard-pressed on every side, yet not crushed; we are perplexed, but not in despair.\' A leader must have \'thick skin and a soft heart.\' Don\'t let the critics determine your pace. Use the stones thrown at you to build the foundation of your persistence. Your conviction must be deeper than the disapproval of men.', 7, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(26, 6, 'Legacy: Finishing Well', 'legacy-finishing-well', 'The goal of leadership is not just to start well, but to finish well. 2 Timothy 4:7 record Paul saying, \'I have fought the good fight, I have finished the race, I have kept the faith.\' Legacy is about what happens after you are gone. Effective leaders prepare for succession long before they step down. They invest their lives in the next generation. Your greatest contribution is not the buildings you built or the programs you started, but the character and competence you instilled in those you led. Lead today with an eye on tomorrow.', 8, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(27, 7, 'Spiritual Compatibility', 'spiritual-compatibility', '2 Corinthians 6:14 is the primary anchor for marital selection: \'Do not be unequally yoked together with unbelievers.\' Marriage is the merging of two lives into one. If your spirits are moving in different directions, your life will be filled with friction. Spiritual compatibility is more than just attending the same church. it is about a shared commitment to the Lordship of Christ. When both partners have the same Master, they have a common ground for resolution and growth. Don\'t settle for someone you hope to change; choose someone whose walk with God inspires your own.', 1, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(28, 7, 'Shared Values and Worldviews', 'shared-values-and-worldviews', 'Amos 3:3 asks, \'Can two walk together, unless they are agreed?\' Beyond spiritual belief, there must be agreement on core values—finances, family, ministry, and lifestyle. If one values frugality and the other values luxury, there will be constant tension. If one wants a quiet life and the other wants a global impact, purpose will be frustrated. Discuss these things early. Your values are the compass of your life. If your compasses are pointing in different directions, you will eventually drift apart. Agreement is the environment where the blessing of God flows.', 2, '2026-02-06 06:10:04', '2026-02-06 06:10:04'),
(29, 7, 'Emotional Health and Maturity', 'emotional-health-and-maturity', 'Marriage does not heal emotional wounds; it often exposes them. Before choosing a partner, evaluate their emotional maturity. Do they have self-control? (Proverbs 25:28). How do they handle anger or disappointment? A partner who is emotionally unstable will make for a turbulent home. Look for someone who has taken responsibility for their own healing and growth. Maturity is the ability to prioritize the relationship over the ego. You need a partner who can communicate their needs without manipulation and who can hear yours without defensiveness.', 3, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(30, 7, 'Purpose Alignment', 'purpose-alignment', 'When God made Eve, He called her a \'helper comparable to him\' (Genesis 2:18). This implies that Adam had a task (a purpose) that Eve was designed to help fulfill. Marriage is two purposes becoming one mission. If your partner\'s destination is not compatible with your calling, there will be a tug-of-war. Ask: \'Does this person make me more effective in my divine assignment?\' A right partner is an accelerator of your destiny, not a distraction. Your marriage should be a platform from which you both fulfill the Great Commission.', 4, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(31, 7, 'The Role of Communication', 'the-role-of-communication', 'Proverbs 18:21 says, \'Death and life are in the power of the tongue.\' Communication is the lifeblood of a relationship. Observe how your potential partner speaks to their parents, to waiters, and to you during a disagreement. Do they listen? Do they value truth? Can they apologize? A partner who cannot communicate effectively will leave you feeling isolated and misunderstood. Communication is a skill that can be learned, but the willingness to communicate is a character trait you must look for from the beginning.', 5, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(32, 7, 'Purity and Honor', 'purity-and-honor', 'Hebrews 13:4 declares, \'Marriage is honorable among all, and the bed undefiled.\' Honor is the atmosphere of a healthy relationship. A partner who honors you will respect your boundaries and your walk with God. Purity is not just a rule; it is a protection of the intimacy you will share in marriage. Someone who pressures you to compromise your convictions before marriage is unlikely to respect your convictions after marriage. Look for a partner who values your holiness above their own pleasure.', 6, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(33, 7, 'Wisdom in Selection', 'wisdom-in-selection', 'Proverbs 4:7 says, \'Wisdom is the principal thing.\' While chemistry and attraction are important, they are not enough to sustain a 50-year commitment. Use wisdom. Observe the person in different environments—with friends, under pressure, and in service. Seek the counsel of godly mentors and parents. \'In the multitude of counselors there is safety\' (Proverbs 11:14). Don\'t rush; a lifetime of regret is not worth a moment of excitement. Let the peace of God be your umpire as you make this critical decision.', 7, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(34, 7, 'Marriage as a Covenant', 'marriage-as-a-covenant', 'Marriage is not a contract that can be broken; it is a covenant that must be kept. Matthew 19:6 says, \'What God has joined together, let not man separate.\' In a covenant, you give 100% regardless of what you get back. It is a commitment to stay when things get tough. Look for a partner who understands the weight of a covenant. You need someone who is not looking for an exit strategy but is committed to building a lasting legacy. A covenant marriage is a reflection of Christ\'s love for the Church—unconditional, enduring, and sacrificial.', 8, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(35, 8, 'Faith as a Spiritual Bridge', 'faith-as-a-spiritual-bridge', 'Hebrews 11:1 defines faith as \'the substance of things hoped for, the evidence of things not seen.\' Faith is the bridge between the invisible realm of the Spirit and the visible realm of the physical. It is how we reach into the treasury of heaven and pull out our provision. Believe is a verb—it is an action. To believe is to act as if the Word of God is true, regardless of what your senses tell you. Your physical eyes see the mountain, but your spiritual eyes see the mountain removed. Faith is not denial of reality; it is the invitation of a higher reality.', 1, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(36, 8, 'Understanding Spiritual Law', 'understanding-spiritual-law', 'The spiritual world is not chaotic; it is governed by laws. Romans 8:2 speaks of the \'law of the Spirit of life in Christ Jesus.\' Just as gravity is a law in the physical world, faith is a law in the spiritual world. One of the primary laws is the Law of Faith (Romans 3:27). This law dictates that God responds to faith, not just to need. You can have a great need and still be defeated, but when you apply the law of faith, the supernatural intervention of God is activated. Learning these laws allows you to walk in the supernatural with consistency.', 2, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(37, 8, 'The Power of Affirmation', 'the-power-of-affirmation', 'Mark 11:23 says, \'...whoever says to this mountain... and does not doubt in his heart, but believes that those things he says will be done, he will have whatever he says.\' Your mouth is the release valve of your faith. Affirmation is the act of speaking the Word of God over your life. It is not just positive thinking; it is spiritual decreeing. When you align your confession with God\'s Word, you create a resonance with heaven. Your words frame your world (Hebrews 11:3). Stop talking about your sickness and start talking about your healing. Stop talking about your lack and start talking about your abundance.', 3, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(38, 8, 'The Renewed Mind', 'the-renewed-mind', 'Romans 12:2 instructs us to \'be transformed by the renewing of your mind.\' Your mind is the filter for your faith. If your mind is filled with doubt, fear, and logical impossibilities, it will choke the seed of faith. The gateway to the supernatural requires a mind that is saturated with the possibilities of God. Renewing the mind involves replacing worldly logic with heavenly truth. It is seeing through the lens of \'all things are possible to him who believes\' (Mark 9:23). A mind that thinks like God can believe for what only God can do.', 4, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(39, 8, 'Miracles: The Norm of the Kingdom', 'miracles-the-norm-of-the-kingdom', 'In the early church, signs and wonders were everyday occurrences. Jesus said, \'These signs will follow those who believe\' (Mark 16:17). Miracles are not meant to be rare exceptions; they are meant to be the norm for the believer. A miracle is simply the intervention of a higher spiritual law over a lower physical law. When you walk in faith, you shouldn\'t be surprised by the supernatural; you should be surprised by the lack of it. Miracles are the Father\'s way of confirming His Word and demonstrating His love to a world that needs to see His power.', 5, '2026-02-06 06:10:05', '2026-02-06 06:10:05'),
(40, 8, 'The Holy Spirit: Our Supernatural Partner', 'the-holy-spirit-our-supernatural-partner', 'Acts 1:8 promises, \'You shall receive power when the Holy Spirit has come upon you.\' The Holy Spirit is the executor of the supernatural on earth. He is the one who performs the miracles, gives the words of wisdom, and empowers the believer. Without the Holy Spirit, faith is just a mental exercise. Intimacy with the Spirit is the secret behind every supernatural ministry. He is the \'Helper\' who guides us into all truth and shows us things to come. When you partner with the Holy Spirit, your limitations are removed, and His power becomes your reality.', 6, '2026-02-06 06:10:06', '2026-02-06 06:10:06'),
(41, 8, 'Overcoming the Giant of Fear', 'overcoming-the-giant-of-fear', 'Fear is the opposite of faith. 2 Timothy 1:7 says, \'God has not given us a spirit of fear, but of power and of love and of a sound mind.\' Fear is the gateway to the demonic, just as faith is the gateway to the supernatural. Fear paralyzes your ability to believe. To walk in the supernatural, you must ruthlessly confront and cast out fear. This is done through the perfect love of God (1 John 4:18) and the persistent declaration of the Word. When faith rises, fear must flee. You cannot hold both a seed of doubt and a tree of faith at the same time.', 7, '2026-02-06 06:10:06', '2026-02-06 06:10:06'),
(42, 8, 'Living in Kingdom Reality', 'living-in-kingdom-reality', 'The supernatural is not a place you visit; it is a realm you live in. Colossians 1:13 says we have been \'delivered from the power of darkness and conveyed into the kingdom of the Son of His love.\' Living in kingdom reality means being conscious of your identity as an ambassador of Christ. It is walking with the awareness that the resources of heaven are at your disposal. This lifestyle is marked by peace, joy, and constant communion with the Father. When you live from the Kingdom perspective, the \'impossible\' becomes your everyday playground.', 8, '2026-02-06 06:10:06', '2026-02-06 06:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('video','audio','mixed') NOT NULL DEFAULT 'video',
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `price`, `is_free`, `instructor_id`, `type`, `is_published`, `category`, `created_at`, `updated_at`) VALUES
(1, 'the skillful prayer', NULL, 'it is what it is', NULL, 40.00, 0, 1, 'video', 1, NULL, '2026-02-03 22:59:38', '2026-02-03 22:59:38'),
(2, 'this is the title', NULL, 'here is a little discrption to get us going and know why why we are here at the first place', 'assets/images/courses/1770644768.jpg', 0.00, 0, 3, 'video', 1, NULL, '2026-02-09 12:46:08', '2026-02-09 12:46:08'),
(3, 'The Divine Blueprint: Mastering Ministerial Excellence', 'the-divine-blueprint', 'A comprehensive journey into the core strategies for modern ministerial impact. This course covers everything from digital outreach to spiritual leadership alignment.', 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?auto=format&fit=crop&q=80&w=1000', 25000.00, 0, 1, 'video', 1, 'Leadership', '2026-02-10 05:37:58', '2026-02-10 05:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `donor_name` varchar(255) DEFAULT NULL,
  `donor_email` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'card',
  `transaction_ref` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `paid_at`, `payment_reference`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'active', NULL, NULL, '2026-02-09 12:51:54', '2026-02-09 12:51:54'),
(2, 2, 2, 'active', NULL, NULL, '2026-02-09 22:54:52', '2026-02-09 22:54:52'),
(3, 2, 3, 'active', NULL, NULL, '2026-02-10 10:19:23', '2026-02-10 10:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `day` enum('Monday','Tusday','Wednesday','Thursday','Friday','Satuday','Sunday') NOT NULL DEFAULT 'Monday',
  `month` enum('Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct','Nov','Dec') NOT NULL,
  `year` varchar(255) NOT NULL,
  `status` enum('comming','passed') NOT NULL DEFAULT 'comming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `recurrence` enum('none','daily','weekly','monthly','yearly') NOT NULL DEFAULT 'none',
  `type` enum('program','service','activity') NOT NULL DEFAULT 'program',
  `extra_dates` text DEFAULT NULL,
  `loop_extra_dates` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `image`, `location`, `time`, `date`, `day`, `month`, `year`, `status`, `created_at`, `updated_at`, `end_time`, `end_date`, `recurrence`, `type`, `extra_dates`, `loop_extra_dates`) VALUES
(1, '5 sunagys of wonders', 'this is the event discription', 'assets/images/events/1770357108.png', 'main auditoruim', '08:00', '2026-02-01', 'Sunday', 'Feb', '2026', 'comming', '2026-02-06 04:34:28', '2026-02-06 04:51:48', NULL, '2026-03-01', 'weekly', 'program', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('registered','confirmed','cancelled') NOT NULL DEFAULT 'registered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_records`
--

CREATE TABLE `financial_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `entry_date` date NOT NULL,
  `recorded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_records`
--

INSERT INTO `financial_records` (`id`, `type`, `category`, `amount`, `description`, `entry_date`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 'income', 'Tithe', 50000.00, 'sunday tithe', '2026-02-01', 1, '2026-02-04 09:26:32', '2026-02-04 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('video','text','live_stream','zoom_meeting','quiz') NOT NULL DEFAULT 'video',
  `video_url` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `quiz_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`quiz_data`)),
  `live_url` varchar(255) DEFAULT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `module_id`, `title`, `type`, `video_url`, `content`, `quiz_data`, `live_url`, `is_free`, `order`, `created_at`, `updated_at`) VALUES
(1, 2, 'how it all workes', 'text', NULL, 'this is a text content moduel', NULL, NULL, 1, 0, '2026-02-09 12:51:07', '2026-02-09 12:51:07'),
(2, 3, 'The Visionary Leader', 'video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '<p>In this lesson, we explore the fundamental qualities of a visionary leader in the 21st century church.</p>', NULL, NULL, 0, 1, '2026-02-10 05:37:58', '2026-02-10 05:37:58'),
(3, 3, 'Strategic Alignment', 'video', 'https://www.youtube.com/watch?v=9No-FiE9Gwc', '<p>How to align your ministerial goals with your core spiritual values.</p>', NULL, NULL, 0, 2, '2026-02-10 05:37:58', '2026-02-10 05:37:58'),
(4, 3, 'Foundations Knowledge Check', 'quiz', NULL, '<p>Test your knowledge.</p>', '{\"title\":\"Foundations Assessment\",\"passing_score\":70,\"questions\":[{\"question\":\"What is the primary focus of a visionary leader?\",\"options\":[\"Maintaining status quo\",\"Future growth and alignment\",\"Purely administrative tasks\",\"Individual recognition\"],\"correct_answer\":1},{\"question\":\"How many years of research does Dr. Julian have?\",\"options\":[\"5 years\",\"10 years\",\"15 years\",\"20 years\"],\"correct_answer\":2},{\"question\":\"True or False: Strategic alignment requires spiritual core values.\",\"options\":[\"True\",\"False\"],\"correct_answer\":0}]}', NULL, 0, 3, '2026-02-10 05:37:59', '2026-02-10 05:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `host_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `room_code` varchar(20) NOT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_participants` int(11) NOT NULL DEFAULT 1,
  `allowed_student_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_student_ids`)),
  `attended_student_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attended_student_ids`)),
  `type` varchar(255) NOT NULL DEFAULT 'scheduled',
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','scheduled','active','ended','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `host_id`, `title`, `description`, `room_code`, `scheduled_at`, `price`, `max_participants`, `allowed_student_ids`, `attended_student_ids`, `type`, `visibility`, `is_public`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'nnn', ',  ,jbjl', 'MAJ-STGE-DJJ', NULL, 0.00, 1, NULL, NULL, 'instant', 'public', 0, 'ended', '2026-02-04 00:08:09', '2026-02-04 00:56:51'),
(2, 1, 'uhiu', 'hi', 'SVT-CY0I-IXI', NULL, 0.00, 1, NULL, NULL, 'instant', 'public', 0, 'active', '2026-02-04 00:57:59', '2026-02-04 00:57:59'),
(3, 3, 'student instructor session', 'it is that you neend to expext', 'XT2njh0kS7', '2026-02-18 11:00:00', 0.00, 1, NULL, NULL, 'instant', 'public', 0, 'scheduled', '2026-02-10 05:07:10', '2026-02-10 05:07:10'),
(4, 1, 'Mastering Digital Ministry', 'A deep dive into digital tools for modern churches.', 'DIGITAL101', '2026-02-12 11:26:53', 25000.00, 10, NULL, NULL, 'masterclass', 'public', 0, 'scheduled', '2026-02-10 10:14:05', '2026-02-10 10:26:53'),
(5, 1, 'Personal Mentorship Session', '1-on-1 ministerial guidance.', 'PRIVATE777', '2026-02-15 11:26:53', 75000.00, 1, '[2]', NULL, 'mentorship', 'private', 0, 'scheduled', '2026-02-10 10:14:05', '2026-02-10 10:26:53'),
(6, 1, 'spiritual class', 'spiritual understanding masterclass', 'cNwwcMS8nJ', '2026-02-11 10:00:00', 75000.00, 1, '[2]', NULL, 'mentorship', 'private', 0, 'pending', '2026-02-10 10:36:26', '2026-02-10 10:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2026_01_19_185226_add_details_to_events_table', 3),
(16, '0001_01_01_000000_create_users_table', 4),
(17, '0001_01_01_000001_create_cache_table', 4),
(18, '0001_01_01_000002_create_jobs_table', 4),
(19, '2024_07_30_073146_create_events_table', 4),
(20, '2026_01_19_000001_add_details_to_events_table', 4),
(21, '2026_01_19_000002_create_courses_table', 4),
(22, '2026_01_19_000003_create_modules_table', 4),
(23, '2026_01_19_000004_create_lessons_table', 4),
(24, '2026_01_19_000005_create_enrollments_table', 4),
(25, '2026_01_19_000006_add_role_to_users_table', 4),
(26, '2026_01_19_000007_create_settings_table', 4),
(27, '2026_01_21_072914_add_google_id_to_users_table', 4),
(28, '2026_02_03_201003_create_products_table', 5),
(29, '2026_02_03_201004_create_books_table', 5),
(30, '2026_02_03_201005_create_orders_table', 5),
(31, '2026_02_03_201006_create_order_items_table', 5),
(32, '2026_02_03_222129_create_donations_table', 6),
(33, '2026_02_03_222557_create_event_registrations_table', 7),
(34, '2026_02_03_234511_create_meetings_table', 8),
(35, '2026_02_04_020000_create_financial_records_table', 9),
(36, '2026_02_06_054710_add_extra_dates_to_events_table', 10),
(37, '2026_02_06_062038_add_category_and_pages_to_books_table', 11),
(38, '2026_02_06_064828_create_book_chapters_table', 12),
(39, '2026_02_06_064828_create_user_book_progress_table', 12),
(40, '2026_02_06_221611_add_is_public_to_meetings', 13),
(41, '2026_02_06_221611_add_type_to_courses', 13),
(42, '2026_02_09_130820_create_quiz_results_table', 14),
(43, '2026_02_09_234608_add_profile_fields_to_users_table', 15),
(44, '2026_02_10_002709_add_welcome_video_to_users_table', 16),
(45, '2026_02_10_060614_add_scheduled_to_meeting_status_enum', 17),
(46, '2026_02_10_061329_add_slug_to_courses_table', 18),
(47, '2026_02_10_061720_add_quiz_support_to_lessons_table', 19),
(48, '2026_02_10_062025_add_missing_columns_to_courses_table', 20),
(50, '2026_02_10_065048_enhance_meetings_table_v2', 21),
(51, '2026_02_10_120144_add_attended_students_to_meetings', 22);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `title`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'intro', 0, '2026-02-03 23:07:17', '2026-02-03 23:07:17'),
(2, 2, 'intro to the main thing', 0, '2026-02-09 12:47:52', '2026-02-09 12:47:52'),
(3, 3, 'Foundations of Excellence', 1, '2026-02-10 05:37:58', '2026-02-10 05:37:58'),
(4, 3, 'Advanced Ministerial Strategies', 2, '2026-02-10 05:37:58', '2026-02-10 05:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('digital','physical') NOT NULL DEFAULT 'physical',
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `price`, `image`, `type`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Anointing Oil (Blessed)', 'anointing-oil-blessed', 'Specially consecrated anointing oil for your spiritual journey.', 2500.00, NULL, 'physical', 50, 1, '2026-02-03 19:15:22', '2026-02-03 19:15:22'),
(2, 'The Power of Prayer (Digital Guide)', 'the-power-of-prayer-digital', 'A comprehensive PDF guide on deepening your prayer life.', 1500.00, NULL, 'digital', 999, 1, '2026-02-03 19:15:22', '2026-02-03 19:15:22'),
(3, 'DBIM Branded T-Shirt', 'dbim-branded-tshirt', 'High-quality cotton t-shirt with DBIM logo.', 5000.00, NULL, 'physical', 100, 1, '2026-02-03 19:15:23', '2026-02-03 19:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `passed` tinyint(1) NOT NULL DEFAULT 0,
  `attempts` int(11) NOT NULL DEFAULT 1,
  `answers_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answers_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RGnbOthuN1T8NgKNDwZYLyMC42UXLJIkFFDomfMu', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWTRzMXExc0V3ZzNsMVJmc1BlWm5za2FKZWpJc0Z4QlZveFJyWnNUUCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vbG9jYWxob3N0L2RiaW0vY291cnNlLzMvbGVhcm4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc3MDczNDU5Mjt9fQ==', 1770735526),
('UtnI5QgT3nMMEsHBmPjAdzDo4TwiwOdqsr2Bg9LI', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibTltZXo0Tk5XMTdjU1hrNjdQNGxaa1Q5bEY5R3RDa05zNmxOaWJFbiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg0OiJodHRwOi8vbG9jYWxob3N0L2RiaW0vY291cnNlLzMvdGhlLWRpdmluZS1ibHVlcHJpbnQtbWFzdGVyaW5nLW1pbmlzdGVyaWFsLWV4Y2VsbGVuY2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc3MDcyMTA0ODt9fQ==', 1770725196);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'live_embed_code', '<iframe width=\"1351\" height=\"480\" src=\"https://www.youtube.com/embed/NnYLzGMk8Tg\" title=\"Can I Vibecode a $250M App Better Than a Pro Developer? (With No Code)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2026-02-03 23:43:08', '2026-02-03 23:43:08'),
(2, 'is_live', '0', '2026-02-03 23:43:08', '2026-02-06 04:25:02'),
(3, 'stream_key', '2571d4ac76eddcb1a9f00b95b80d6268', '2026-02-03 23:49:55', '2026-02-03 23:49:55'),
(4, 'live_source_type', 'embed', '2026-02-03 23:52:52', '2026-02-05 17:36:56'),
(5, 'stream_server_url', NULL, '2026-02-03 23:52:52', '2026-02-05 17:36:56'),
(6, 'playback_url', NULL, '2026-02-03 23:52:52', '2026-02-03 23:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `welcome_video_url` varchar(255) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `years_ministry` varchar(255) DEFAULT NULL,
  `rating` decimal(3,1) NOT NULL DEFAULT 5.0,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin','instructor','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `bio`, `welcome_video_url`, `headline`, `years_ministry`, `rating`, `social_links`, `email`, `google_id`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin User', NULL, NULL, NULL, NULL, 5.0, NULL, 'admin@dbim.com', NULL, NULL, NULL, '$2y$12$RdKZTP35bLTpjeUXeApcAe7tC.JQL2FXa.9F8qcZs9CkupkGgpPku', NULL, '2026-02-03 18:16:49', '2026-02-03 19:15:20', 'admin'),
(2, 'John Student', 'this my bio im a student who drives for excelency and innovation through knowladge because i am gonna take my world by storm', NULL, NULL, NULL, 5.0, NULL, 'student@dbim.com', NULL, 'avatars/QKR5bgWoalor8sCFeMnUAO2qk7Lb4doMsGTAjWMy.png', NULL, '$2y$12$jbl4/IbWNKggTNXM.QEDpuK/yeAl.wGKbixYoKOpBHaYGJih5JUx6', NULL, '2026-02-03 18:16:49', '2026-02-10 10:26:53', 'student'),
(3, 'Instructor User', NULL, NULL, NULL, NULL, 5.0, NULL, 'instructor@dbim.com', NULL, NULL, NULL, '$2y$12$1LD0M5F64oh3UFKjj.4pfOIP.L975wyJ/546/EGYgiIzRQ5tKdxZq', NULL, '2026-02-03 18:16:50', '2026-02-03 19:15:21', 'instructor');

-- --------------------------------------------------------

--
-- Table structure for table `user_book_progress`
--

CREATE TABLE `user_book_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `last_chapter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage_complete` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_book_progress`
--

INSERT INTO `user_book_progress` (`id`, `user_id`, `book_id`, `last_chapter_id`, `percentage_complete`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 1.90, '2026-02-06 05:56:13', '2026-02-06 05:57:04'),
(3, 1, 8, 35, 5.90, '2026-02-06 06:11:45', '2026-02-06 08:42:01'),
(5, 2, 8, 35, 26.10, '2026-02-08 22:37:27', '2026-02-08 22:37:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_slug_unique` (`slug`);

--
-- Indexes for table `book_chapters`
--
ALTER TABLE `book_chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_chapters_book_id_foreign` (`book_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_instructor_id_foreign` (`instructor_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_user_id_foreign` (`user_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_user_id_foreign` (`user_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_registrations_event_id_foreign` (`event_id`),
  ADD KEY `event_registrations_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_records_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_module_id_foreign` (`module_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meetings_room_code_unique` (`room_code`),
  ADD KEY `meetings_host_id_foreign` (`host_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_course_id_foreign` (`course_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_results_user_id_foreign` (`user_id`),
  ADD KEY `quiz_results_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_book_progress`
--
ALTER TABLE `user_book_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_book_progress_user_id_book_id_unique` (`user_id`,`book_id`),
  ADD KEY `user_book_progress_book_id_foreign` (`book_id`),
  ADD KEY `user_book_progress_last_chapter_id_foreign` (`last_chapter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `book_chapters`
--
ALTER TABLE `book_chapters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_records`
--
ALTER TABLE `financial_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_book_progress`
--
ALTER TABLE `user_book_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_chapters`
--
ALTER TABLE `book_chapters`
  ADD CONSTRAINT `book_chapters_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD CONSTRAINT `financial_records_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_host_id_foreign` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_book_progress`
--
ALTER TABLE `user_book_progress`
  ADD CONSTRAINT `user_book_progress_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_book_progress_last_chapter_id_foreign` FOREIGN KEY (`last_chapter_id`) REFERENCES `book_chapters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_book_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
